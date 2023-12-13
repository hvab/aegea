<?php

namespace Neasden;

interface RendererExtension {
  public function render ($interpretation, $myconf);
}

class Renderer {

  private $language_data;

  private $model = null;
  private $configuration = null;
  private $rx_tags_regex;

  protected $isolations;

  public $extensions = [];

  const RX_SPECIAL_CHAR = "\x1";
  const RX_SPECIAL_SEQUENCE_LENGTH = 6;

  const MAX_H_LEVEL = 6;

  function __construct (
    Configuration $configuration = null,
    Model $model = null
  ) {

    $this->rx_tags_regex = (
      '(?:'. 
      '\\' . self::RX_SPECIAL_CHAR .'\d{'. self::RX_SPECIAL_SEQUENCE_LENGTH .'}\\' . self::RX_SPECIAL_CHAR.
      ')*'
    );

    $this -> setConfiguration ($configuration);

    $this -> setModel ($model);

  }


  public function setConfiguration ($configuration) {

    $this->configuration = $configuration;

    if ((string) @$this->configuration->language !== '') {
      $this->language_data = require 'languages/'. $this->configuration->language .'.php';
    } else {
      $this->language_data = require 'languages/en.php';
    }

    foreach ($this->configuration -> getExtensions () as $data) {
      $this -> loadExtension ($data['renderer-filename']);
    }

  }


  public function getConfiguration () {

    return $this->configuration;
    
  }


  public function setModel ($model) {

    $this->model = $model;

  }


  private function loadExtension ($file) {
    $name = basename ($file);
    if (substr ($name, -4) == '.php') $name = substr ($name, 0, strlen ($name) - 4);
    if (!array_key_exists ($name, $this->extensions)) {
      $NeasdenGroupClass = 'Neasden\\' . $name;
      include_once $file;
      $this->extensions[$name] = [
        'path' => dirname ($file) .'/'. $name .'/',
        'instance' => new $NeasdenGroupClass ($this),
      ];
      return true;
    }
  }


  private function ensureReadiness () {

    if ($this->configuration === null) {
      throw new \LogicException (
        'Configuration must be set in constructor or with setModel'
      );
    }

    if ($this->model === null) {
      throw new \LogicException (
        'Model must be set in constructor or with setModel'
      );
    }

  }


  protected function specialSequence ($index) {
    return self::RX_SPECIAL_CHAR . str_pad ($index, self::RX_SPECIAL_SEQUENCE_LENGTH, '0', STR_PAD_LEFT) . self::RX_SPECIAL_CHAR;
  }


  // public, because audio extension uses it
  public function isolate ($tag) {
    $index = count ($this->isolations);
    if (is_array ($tag)) $tag = $tag[0];
    $this->isolations[$index] = $tag;
    return $this -> specialSequence ($index);
  }
    
  
  public function unisolate ($text) {

    // ineffective version:
    // foreach ($this->isolations as $index => $value) {
    //   $text = str_replace ($this -> specialSequence ($index), $value, $text);
    // }
    // return $text;

    $unisolated = '';
    for ($i = 0; $i < strlen ($text); ++ $i) {
      if ($text[$i] !== self::RX_SPECIAL_CHAR) {
        $unisolated .= $text[$i];
        continue;
      } else {
        $potential_special_sequence = '';
        for ($j = $i; $j < $i + self::RX_SPECIAL_SEQUENCE_LENGTH + 2; ++ $j) {
          $potential_special_sequence .= $text[$j];
        }
        $index = (int) substr ($potential_special_sequence, 1, -1);
        if ($potential_special_sequence === $this -> specialSequence ($index)) {
          $unisolated .= $this->isolations[$index];
          $i += self::RX_SPECIAL_SEQUENCE_LENGTH + 1;
        }
      }
    }
    return $unisolated;

  }
  



  // makes a particular kind of smart quotes
  public function renderGroup ($class, $subclass, $lines) {
  
    if (!$class) return null;

    $rendererClass = $class .'Renderer';

    if ($class == 'p') {

  
      return '<p>'. implode ('<br />'."\n", $lines) .'</p>'."\n";
      
  
    } elseif ($class == 'h') {

      $line = $lines[0];
      $hlevel = min (
        (int) $subclass + // is a heading level in case of h
        ((int) @$this->configuration->groupsHeadingsPlus),
        self::MAX_H_LEVEL
      );
      $tag_name = 'h'. $hlevel;
      // return '<'. $tag_name .'>'. $line['content'] .'</'. $tag_name .'>'."\n";
      return '<'. $tag_name .'>'. $line .'</'. $tag_name .'>'."\n";
  
    } elseif (isset ($this->extensions[$rendererClass])) {

      return $this->extensions[$rendererClass]['instance'] -> render (
        $lines,
        (array) @$this->configuration->extensions[$class]
      );
  
    } else {

      return null;
  
    }
  
  }
  
  
  private function smartQuotesDiversifyChar ($char, $left, $right, $text) {

    $before_open = '^|\s|[-(\[]';
    $after_close = '$|\s|[-)\].,!?]';

    // double chars
    if (1) {
      $text = preg_replace (
        '/((?:'. $before_open .')'. $this->rx_tags_regex .')'.
        preg_quote ($char) . preg_quote ($char).
        '(?!'. $this->rx_tags_regex .'($|\-|\s))/m',
        '$1'. $left. $left,
        $text
      );
    }
  
    if (1) {
      $text = preg_replace (
        '/(?<!^|\s|\-)('. $this->rx_tags_regex .')'.
        preg_quote ($char) . preg_quote ($char).
        '(?='. $this->rx_tags_regex . '(?:'. $after_close . '))/m',
        '$1'. $right. $right,
        $text
      );
    }

    // single chars
    if (1) {
      $text = preg_replace (
        '/((?:'. $before_open .')'. $this->rx_tags_regex .')'.
        preg_quote ($char).
        '(?!'. $this->rx_tags_regex .'($|\-|\s))/m',
        '$1'. $left,
        $text
      );
    }
  
    if (1) {
      $text = preg_replace (
        '/(?<!^|\s|\-)('. $this->rx_tags_regex .')'.
        preg_quote ($char).
        '(?='. $this->rx_tags_regex . '(?:'. $after_close . '))/m',
        '$1'. $right,
        $text
      );
    }

    return $text;

  }

  
  private function smartQuotes ($text) {
  
    // echo '1350='. (self::stopwatch () - $this->stopwatch)."<br>";
    if ($text === '') return '';

    $dumb = $this->language_data['quotes-dumb'];
    if (count ($dumb) == 0) return;

    $quotes = $this->language_data['quotes'];
    if (count ($quotes) == 0) return;
    if (count ($quotes) == 1) $quotes[1] = $quotes[0];
    if (count ($quotes) == 2) {
      $quotes[3] = $quotes[1];
      $quotes[2] = $quotes[1];
      $quotes[1] = $quotes[0];
    }
    if (count ($quotes) == 3) $quotes[3] = $quotes[2];

    // if a special dumb char is given for inner quotes,
    // replace it first:
    if (isset ($dumb[1])) $text = $this -> smartQuotesDiversifyChar (
      $dumb[1], $quotes[1], $quotes[2], $text
      /*   ' ‘ ’   */
    );
  
    // echo '1354='. (self::stopwatch () - $this->stopwatch)."<br>";
    // obvious replacements:
    $text = $this -> smartQuotesDiversifyChar (
      $dumb[0], $quotes[0], $quotes[3], $text
      /*   " “ ”   or   " « »   */
    );
    // echo '1355='. (self::stopwatch () - $this->stopwatch)."<br>";

    // guess remaining replacements
    if ($this->language_data['quotes-auto-depth']) {

      $text_pointer = 0;
      $text_length = strlen ($text);
      $new_text = '';

      $qdepth = 0;

      while (1) {

        $first_char = ord ($text[$text_pointer]);

        if ($first_char < 128)      $scan_bytes = 1;
        elseif ($first_char < 224)  $scan_bytes = 2;
        elseif ($first_char < 240)  $scan_bytes = 3;
        elseif ($first_char < 248)  $scan_bytes = 4;
        elseif ($first_char == 252) $scan_bytes = 5;
        else                        $scan_bytes = 6;

        $scan = substr ($text, $text_pointer, $scan_bytes);

        if ($scan === false or $scan === '') break;

        if ($scan == $quotes[0]) {
          ++ $qdepth;
          if ($qdepth > 1) $new_text .= $quotes[1];
          else $new_text .= $quotes[0];
        } elseif ($scan == $quotes[3]) {
          if ($qdepth > 1) $new_text .= $quotes[2];
          else $new_text .= $quotes[3];
          -- $qdepth;
        } elseif ($scan == $dumb[0]) {
          if ($qdepth > 0) {
            if ($qdepth > 1)
              $new_text .= $quotes[2];
            else
              $new_text .= $quotes[3];
            -- $qdepth;
          } else {
            $new_text .= $quotes[0];
            ++ $qdepth;
          }
        } else {
          $new_text .= $scan;
        }
        
        $text_pointer += $scan_bytes;
        if ($text_pointer >= $text_length) break;

      }
    }
  
    // echo '1359='. (self::stopwatch () - $this->stopwatch)."<br>";
    return $new_text; 
  
  }
  

  private function processDoubleBracketsContentsCallback ($params) {
  
    $text = @$params[1] . @$params[2] . @$params[3] . @$params[4];
    @list ($href, $text) = explode (' ', $text, 2);

    $quotes = $this->language_data['quotes'];
    $quotes_left = ['"', '\'', $quotes[0], $quotes[1]];
    $quotes_right = ['"', '\'', $quotes[2], $quotes[3]];
    $hang_left = '';
    $hang_right = '';

    if (@$text) {
      $hang_left = mb_substr ($text, 0, 1);
      $hang_right = mb_substr ($text, -1);
    } else {
      // if no text is given, then the whole brackets contents should be the href,
      // it probably contains "//", and thus should be isolated
      $text = $this -> isolate ($href);
    }
    
    $quotes_should_hang = (
      in_array ($hang_left, $quotes_left) and
      in_array ($hang_right, $quotes_right)
    );
  
    $rel_nofollow = '';
    if ($this->configuration->typographyNoFollowHrefs) {
      $rel_nofollow = ' rel="nofollow"';
    }

    if ($quotes_should_hang)  {
      $text = mb_substr ($text, 1, mb_strlen ($text) - 2);
      $class = '';
      if ($this->configuration->typographyUndecoratedLinksCssClass) {
        $class = ' class="'.$this->configuration->typographyUndecoratedLinksCssClass . '"';
      }

      // the tags must be isolated, but the quote marks and the text
      // among them should be typographed
      $a_in = $this -> isolate ('<a href="'. $href .'"'. $rel_nofollow . $class .'>');
      $u_in = $this -> isolate ('<u>');
      $u_out = $this -> isolate ('</u>');
      $a_out = $this -> isolate ('</a>');

      return $a_in . $hang_left . $u_in . $text . $u_out . $hang_right . $a_out;

    } else {
      $a_in = $this -> isolate ('<a href="'. $href .'"'. $rel_nofollow .'>');
      $a_out = $this -> isolate ('</a>');
      if (!@$text) $text = $href;
      return $a_in . $text . $a_out;
    }
  
  }
  

  // converts naked urls in text into working links
  
  private function reviveNakedUrlCallback ($params) {
    
    $possible_space = $params[1];
    $url = $params[2];

    $rel_nofollow = '';
    if ($this->configuration->typographyNoFollowHrefs) {
      $rel_nofollow = ' rel="nofollow"';
    }

    return (
      $possible_space .
      $this -> isolate ('<a href="'. $url .'"'. $rel_nofollow .'>'. $url .'</a>')
    );

  }
  

  // replacements, quotes, dashes, no-break spaces
  // input text must be netto:
  // no html entities, just actual utf-8 chars

  private function typography ($text) {
    
    $nbsp = " ";
  
    $dash = $this->language_data['dash'];
  
    //$span_tsp = $this -> isolate ('<span class=\"tsp\">'. $nbsp .'</span>');
    $nobr_in = $this -> isolate ('<nobr>');
    $nobr_out = $this -> isolate ('</nobr>');

    $text = preg_replace_callback ('/(?:\<[^\>]+\>)/u', [$this, 'isolate'], $text);
  
    if (@$this->configuration->typographyMarkup) {

      // double parentheses and brackets
      $chars = ['\\(', '\\)', '\\[', '\\]'];
      $text = preg_replace_callback (
        '/'.
        '(?:'. $chars[0].$chars[0] .'(?!'. $chars[0] .')(?=\S)(.*?)'.  $chars[1].$chars[1] .')'.
        '|'.
        '(?:'. $chars[0].$chars[0] .'(?!'. $chars[0] .')(.*?)(?<=\S)'. $chars[1].$chars[1] .')'.
        '|'.
        '(?:'. $chars[2].$chars[2] .'(?!'. $chars[2] .')(?=\S)(.*?)'.  $chars[3].$chars[3] .')'.
        '|'.
        '(?:'. $chars[2].$chars[2] .'(?!'. $chars[2] .')(.*?)(?<=\S)'. $chars[3].$chars[3] .')'.
        '/imu',
        [$this, 'processDoubleBracketsContentsCallback'],
        $text
      );
  
      // naked urls in the text
      if (@$this->configuration->typographyAutoHref) {
        $url_regex = (
          '/'.
          '(\s|^|'. $this->rx_tags_regex .')'.
          '((?:https?|ftps?)\:\/\/[\w\d\#\.\/&=%-_!\?\@\*\~]+)'.
          '/isu'
        );
        $text = preg_replace_callback (
          $url_regex,
          [$this, 'reviveNakedUrlCallback'],
          $text
        );
      }

      // wiki stuff: italic, bold, strike through
      $t_in = $t_out = [];
      $duomap = ['/' => 'i', '*' => 'b', '-' => 's'];
      foreach ($duomap as $from => $to) {
        if (!@$t_in[$to]) $t_in[$to] = $this -> isolate ('<'. $to .'>');
        if (!@$t_out[$to]) $t_out[$to] = $this -> isolate ('</'. $to .'>');
        $char = '\\'. $from;
        $text = preg_replace (
          '/'.
          '(?:'. $char.$char .'(?!'. $char .')(?=\S)(.*?)'. $char.$char .')'.
          '|'.
          '(?:'. $char.$char .'(?!'. $char .')(.*?)(?<=\S)'. $char.$char .')'.
          '/imu',
          $t_in[$to] . '$1$2' . $t_out[$to],
          $text
        );
      }
    }

    // quotes
    if (@$this->configuration->typographyQuotes) {
      $text = $this->smartQuotes ($text);
    }
  
    // replacements
    if (1) {
      if (array_key_exists ('replacements', $this->language_data)) {
        $text = str_replace (
          array_keys ($this->language_data['replacements']),
          array_values ($this->language_data['replacements']),
          $text
        );
      }
    }
  
    // dash
    $text = preg_replace (
      '/(?<=^| |'. preg_quote ($nbsp) .')('. $this->rx_tags_regex .')\-('. $this->rx_tags_regex .')(?= |$)/mu',
      '$1'. $dash .'$2',
      $text
    );
  
    // space before dash
    $text = preg_replace (
      '/ ('. $this->rx_tags_regex .')'. preg_quote ($dash) .'/', $nbsp .'$1'. $dash, $text
    );
  
    // unions and prepositions
    if (1) {
      if ($nobreak_fw = $this->language_data['with-next']) {
        $text = preg_replace (
          "/".
          "(?<!\pL|\-)".    // not-a—Unicode-letter-or-dash lookbehind
          $nobreak_fw .     // a preposition
          "(". $this->rx_tags_regex .")".
          " ".              // and a space
          "/isu",      
          '$1$2'. $nbsp,
          $text
        );
      }
  
      if ($nobreak_bw = $this->language_data['with-prev']) {
        $text = preg_replace (
          "/".
          " ".             // a space
          "(". $this->rx_tags_regex .")".
          $nobreak_bw .    // a particle
          "(?!\pL|\-)".    // not-a—Unicode-letter-or-dash lookforward
          "/isu",      
          $nbsp .'$1$2',
          $text
        );
      }
    }
  
  
    return $text;
  
  }


  public function processOpaqueFragment ($text) {

    // replace &laquo; with normal quote characters
    $text = str_replace (
      array_keys ($this->configuration->typographyCleanup),
      array_values ($this->configuration->typographyCleanup),
      $text
    );

    if ($this->configuration->typographyOn) {
      $text = $this -> typography ($text);
    }

    return $text;
  
  }

  public function getLinksHTML ($library) {

    $this -> ensureReadiness ();

    $html = '';
    foreach ($this->model -> getLinks () as $link) {
      if (parse_url ($link, PHP_URL_SCHEME) === null) {
        $link = $library . $link;
      }
      if (substr ($link, -3) == '.js') {
        $html .= '<script src="'. $link .'"></script>' ."\n";
      }
      if (substr ($link, -4) == '.css') {
        $html .= '<link rel="stylesheet" href="'. $link .'" />' ."\n";
      }
    }

    return $html;

  }


  public function getHTML () {

    $this -> ensureReadiness ();

    $this->isolations = [];

    $html = '';
    foreach ($this->model -> getFlow () as $element) {

      $band = Model::expandFlowElement ($element);

      if ($band['kind'] === 'group') {
        $html .= $this -> renderGroup (
          $band['class'],
          $band['subclass'],
          $band['lines']
        );
        continue;
      }

      // raw html and code blocks should be isolated
      if ($band['class'] == '_o') {
        $html .= $band['content'];
        continue;
      }

      if ($band['class'] == '_r') {
        $html .= $this -> isolate ($band['content']);
        continue;
      }

      if ($band['class'] == '_c') {

        if ($this->configuration->htmlCodeOn) {
          $content = (
            sprintf ($this->configuration->htmlCodeWrap[0], $band['subclass']) .
            htmlspecialchars ($band['content']) .
            $this->configuration->htmlCodeWrap[1]
          );
        } else {
          $content = '<code>'. $band['content'] .'</code>';
        }

        $html .= $this -> isolate ($content);
        continue;
      }

    }

    $html = $this -> processOpaqueFragment ($html);

    $html = $this -> unisolate ($html);
  
    return $html;
  }

}

?>