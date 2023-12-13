<?php

// Neasden Version 3.0 (alpha)

namespace Neasden;

interface InterpreterExtension {
  public function interpret ($group, $myconf);
}

class Interpreter {
  
  // 0.text = grouped, typographed
  // 7.opaque == typographed
  // 9.sacred == returned as is

  private $configuration;

  private $has_run;

  protected $input;
  protected $stream_log;
  protected $fragments;
  protected $model;

  public $extensions = [];
  public $groups_used;

  const INITIAL_STREAM_STATE = 'text';
  const DEFAULT_GROUP = 'p';
  const N2_DEBUG = false;

  private $groups = [
    'empty'   => '(-empty-)+',
    'p'       => '(-p-)+',
    'h'       => '(-h-)',
  ];

  private $line_classes = [];
  private $required_line_classes = [];

  function __construct (Configuration $configuration, $input = null) {

    $this->configuration = $configuration;

    $this -> setInput ($input);

    foreach ($this->configuration -> getExtensions () as $data) {
      $this -> loadExtension ($data['interpreter-filename']);
    }

  }
    

  public function setInput ($input) {

    $this->input = $input;
    $this -> resetState ();

  }


  private function resetState () {

    $this->model = new Model ();
    $this->model->debug = self::N2_DEBUG;

    if (self::N2_DEBUG) {
      $this->stream_log = [];
    }

    $this->fragments = [];

    $this->groups_used = [];

    $this->has_run = false;

  }


  private function loadExtension ($file) {
    $name = basename ($file);
    if (substr ($name, -4) == '.php') $name = substr ($name, 0, strlen ($name) - 4);
    if (!array_key_exists ($name, $this->extensions)) {
      $NeasdenInterpreterExtension = 'Neasden\\'. $name;
      include_once $file;
      $this->extensions[$name] = [
        'path' => dirname ($file) .'/'. $name .'/',
        'instance' => new $NeasdenInterpreterExtension ($this),
      ];
      return true;
    }
  }


  // return a group class by it’s current running definition
  private function matchingGroup ($rdef) {
    foreach ($this->groups as $group_class => $group_regex) {
      if (
        preg_match ('/^'. $group_regex .'$/', $rdef)
      ) {
        $this->groups_used[] = $group_class;
        return $group_class;
      }
    }
  }
  
  
  private function parseGroupLine ($line) {
  
    $line = rtrim ($line);
  
    $result = [
      'class' => 'p',
      'content' => $line,
      'class-data' => null,
    ];
  
    if (strlen ($line) == 0) {
      $result['class'] = 'empty';
      return $result;
    }
  
    // headings
    $line_hashless = ltrim ($line, $this->configuration->groupsHeadingsChar);
    $heading_level = strlen ($line) - strlen ($line_hashless);
    if ($heading_level > 0 and $line_hashless[0] == ' ') {
      $result['content'] = ltrim ($line_hashless, ' ');
      $result['class'] = 'h';
      $result['-heading-level'] = $heading_level;
      return $result;
    }

    // echo '<pre>';
    // print_r( $this->line_classes);
    // die;
  
    // other classes
    foreach ($this->line_classes as $class => $regex) {
      $regex = '/^(?:'. $regex .')$/isu';
      if (preg_match ($regex, $line, $matches)) {
  
        if (
          !@$this->extensions[$class .'Interpreter']['instance']
          // получается, что метод detectLine сработает 
          // только у тех строк, которые называются
          // ровно точно так же, как сам extension
          or !method_exists (@$this->extensions[$class .'Interpreter']['instance'], 'detectLine')
          or $this->extensions[$class .'Interpreter']['instance'] -> detectLine (
            $line, (array) @$this->configuration->extensions[$class]
          )
        ) {
          $result['class'] = $class;
          $result['class-data'] = $matches;
          return $result;
        }
      }
    }
  
    return $result;
  
  }
  

  private function groups ($text) {
  
    $src_lines = explode ("\n", $text);
    $src_lines[] = '';
  
    $prev_quote_level = 0;
  
    $prev_spaceshift = 0;
    $depths_spaceshifts = [0];
    $depth = 0;
  
    $last_group_class = self::DEFAULT_GROUP;
  
    $groups = [];
    $good_buffer = [];
  
    $rdef = '';

    // echo '<pre>';
    // print_r ($src_lines);
    // echo '</pre>';
  
    foreach ($src_lines as $src_line) {
  
      // quote level
      $line_quoteless = ltrim ($src_line, $this->configuration->groupsQuotesChar);
      $quote_level = strlen ($src_line) - strlen ($line_quoteless);
      $src_line = $line_quoteless;
      $quote_level_changed = ($prev_quote_level != $quote_level);
      $quote_level_inc = max (0, $quote_level - $prev_quote_level);
      $quote_level_dec = max (0, $prev_quote_level - $quote_level);
      $prev_quote_level = $quote_level;
  
      // analize spaceshifts and depth
      $line = ltrim ($src_line, ' ');
      $spaceshift = strlen ($src_line) - strlen ($line);
      if ($spaceshift > $prev_spaceshift) {
        $depth ++;
        $depths_spaceshifts[] = $spaceshift;
      }
      if ($spaceshift < $prev_spaceshift) {
        $new_depth = 0;
        foreach ($depths_spaceshifts as $depth_spaceshift) {
          if ($spaceshift > $depth_spaceshift) {
            $new_depth ++;
          } else {
            $spaceshift = $depth_spaceshift;
            break;
          }
        }
        while ($depth > $new_depth) {
          $depth --;
          array_pop ($depths_spaceshifts);
        }
      }
      $prev_spaceshift = $spaceshift;
  
      // parse and match line groups

      $line = $this -> parseGroupLine ($line);
      // $line['src-line'] = $src_line;
      $line['result'] = '';
      $line['depth'] = $depth;
      $rdef .= '-'. $line['class'] .'-';
  
      if (self::N2_DEBUG) {
        $line['debug'] = implode ("-\n-", explode ('--', $rdef));
      }
  
      $match_found = false;
  
      if ($group_class = $this -> matchingGroup ($rdef) and !$quote_level_changed) {
        $last_group_class = $group_class;
        $match_found = true;
        $good_buffer[] = $line;
      }
  
      if ($quote_level_changed or !$match_found) {
  
        if (self::N2_DEBUG) {
          if ($quote_level_changed) {
            $line['debug'] .= "\n".'quotelevelchanged ';
          }
    
          if (!$match_found) {
            $line['debug'] .= "\n".'nomatch ';
          }
        }
        
        if (!count ($good_buffer)) $last_group_class = 'empty';
        
        $groups[] = [
          'class' => $last_group_class,
          'lines' => $good_buffer,
          'quote_level_inc' => $quote_level_inc,
          'quote_level_dec' => $quote_level_dec,
        ];

        // now the widow line should be processed as part of next group
  
        $good_buffer = [$line];
        $rdef = '-'. $line['class'] .'-';
        $last_group_class = $this -> matchingGroup ($rdef) or $last_group_class = self::DEFAULT_GROUP;
  
      }
  
    }
  
    $groups[] = ['class' => $last_group_class, 'lines' => $good_buffer];

    return $groups;
  
  }
  
  
  private function elementStrength ($element) {
    if (strstr (' '. $this->configuration->htmlElementsSacred .' ', ' '. $element .' ')) {
      return '9.sacred';
    }
    if (strstr (' '. $this->configuration->htmlElementsOpaque .' ', ' '. $element .' ')) {
      return '7.opaque';
    }
    return '0.markup';
  }
  
  
  // return a clean html element name given its html representation
  // e. g. '<P Class=some>' -> 'p'  
  private function htmlElementName ($text) {
    if ($text[0] != '<') return;
    if ($text[strlen ($text) - 1] != '>') return;
    $text = ltrim (substr ($text, 1, -1)) . ' '; // utf8-safe: checked 128ness above
    $text = substr ($text, 0, strpos ($text, ' ')); // utf8-safe: paired
    return strtolower (rtrim ($text)); // utf8-safe: who cares
  }

  
  public function requireLineClass ($class) {
    $this->required_line_classes[$class] = true;
  }
  
  
  public function defineLineClass ($class, $regex) {
    $this->line_classes[$class] = $regex;
  }
    
  
  public function defineGroup ($group, $regex) {
    $this->groups[$group] = $regex;
  }
    
  // !!! shoudn’t this leave in NeasdenGroup?
  public function resourceDetected ($resource) {
    $this->model -> addResource ($resource);
  }
  
  
  public function requireLink ($link) {
    $this->model -> addLink ($link);
  }

  // split into fragments of different strength such as
  // 0.text, 7.opaque, and 9.sacred, and also code
  private function streamToFragments () {

    if ($this->fragments !== []) {
      throw new \LogicException ('streamToFragments () called for the second time');
    }
      
    $machine = [
      'text' => [
        '<' => 'tag',
      ],
      'tag' => [
        '<' => 'tag--oops-it-was-text-before', // why is that? why not leave the previous char as tag anyway. and what happens in case of > >?
        '>' => 'text',
        "'" => 'attr-s',
        '"' => 'attr-d',
      ],
      'attr-s' => [
        "'" => 'tag',
      ],
      'attr-d' => [
        '"' => 'tag',
      ],
      'comment' => [],
      'code' => [],
    ];
  
    // raw length
    $l_raw = strlen ($this->input);
    $r = '';
    $prevstate = self::INITIAL_STREAM_STATE;
    $state = self::INITIAL_STREAM_STATE;
    $tagstack = [];
    $thisfrag = ['content' => '', 'strength' => -1];
    $current_el = '';
    $code_nesting = 0;

    for ($i = 0; $i < $l_raw; $i ++) {

      // next raw byte
      $c_el = $this->input[$i];
      $c = $c_el;
      
      // make utf-8 char
      if (ord ($c_el) >= 192) {
        $c_el = $this->input[$i + 1];
        while ((ord ($c_el) >= 128) && (ord ($c_el) < 192)) {
          $i ++;
          $c .= $c_el;
          if ($i + 1 < $l_raw) {
            $c_el = $this->input[$i + 1];
          } else {
            break;
          }
        }
      }

      $r .= $c;
  
      // auto manage state machine
      if (array_key_exists ($c, $machine[$state])) {
        $state = $machine[$state][$c];
      }
      
      if ($state == 'tag--oops-it-was-text-before') {
        $prevstate = 'text'; // boy is this dirty
        $state = 'tag';
      }
      
      // make sure tag is real. must start with a letter or "!"
      // why doesn’t this cover the cases of << and < <?
      if ($state == 'tag' and mb_strlen ($r) == 2) {
        if ($r[0] == '<' and !preg_match ('/\<(\/|\w|\!)/i', $r)) {
          $prevstate = 'text';
          $state = 'text';
        }
      }

      if (self::N2_DEBUG) {
        $this->stream_log[] = ['char', $c, $state];
      }

      // html comments: manually manage states
      if ($state == 'tag' and $r == '<!--') {
        $state = 'comment';
        if ($thisfrag['content'] !== '') {
          $this->fragments[] = $thisfrag;
          if (self::N2_DEBUG) {
            $this->stream_log[] = ['frag', $thisfrag, 'HTML comment started'];
          }
        }
        $thisfrag = ['content' => $r, 'strength' => -1];
        $r = '';
      }

      if ($state == 'comment' and substr ($r, -3, 3) == '-->') { 
        $state = 'text';
        $thisfrag['content'] .= $r;
        $thisfrag['strength'] = '9.sacred';
        if ($thisfrag['content'] !== '') {
          $this->fragments[] = $thisfrag;
          if (self::N2_DEBUG) {
            $this->stream_log[] = ['frag', $thisfrag, 'HTML comment ended'];
          }
        }
        $thisfrag = ['content' => '', 'strength' => -1];
        $r = '';
      }
    
      if (
        in_array ($state, ['text', 'code', 'tag']) and
        (
          (strcasecmp (substr ($r, 0, 5), '<code') === 0)  // optimize as hell
          or $code_nesting > 0 // but not if nesting, here regexp is necessary
        ) and
        preg_match ('/<code(?:\s+lang=([^> ]+)\s*)?>$/si', $r, $m)
      ) {
        if ($state == 'tag') {
          $prevstate = 'text'; // boy is this dirty
        }
        ++ $code_nesting;
        if ($code_nesting == 1) {
          $state = 'code';
          if ($thisfrag['content'] !== '') {
            $this->fragments[] = $thisfrag;
            if (self::N2_DEBUG) {
              $this->stream_log[] = ['frag', $thisfrag, 'code started'];
            }
          }
          $thisfrag = [
            'content' => '', // don’t put the very <code> tag here
            'strength' => '9.sacred',
            'code' => 1,
            'lang' => isset($m[1]) ? trim($m[1], '"\'') : ''
          ];
          $r = '';
        }
      }
      
      if ($state == 'code' and substr ($r, -7, 7) == '</code>') { 
        // echo htmlspecialchars ($r);
        // die;
        -- $code_nesting;
        if ($code_nesting < 1) {
          $state = 'text';
          $r = substr ($r, 0, -7); // remove the closing </code> tag from here
          $r = trim ($r);
          $thisfrag['content'] = $r;
          if ($thisfrag['content'] !== '') {
            $this->fragments[] = $thisfrag;
            if (self::N2_DEBUG) {
              $this->stream_log[] = ['frag', $thisfrag, 'code ended'];
            }
          }
          $thisfrag = ['content' => '', 'strength' => -1];
          $r = '';
        }
      }
  
      // state change
      if ($state != $prevstate) {
        if ($prevstate == 'text' and $state == 'tag') {

          // state changes from text to tag,
          // so commit all previous text to this fragment
          // start a new run with a '<'
          // and then just see how it goes from there
          $thisfrag['content'] .= mb_substr ($r, 0, -1);
  
          // set strength if not yet set
          if ($thisfrag['strength'] == -1) {
            $thisfrag['strength'] = $this -> elementStrength ($current_el);
          }
          
          $r = mb_substr ($r, -1, 1);
  
        } elseif ($prevstate == 'tag' and $state == 'text') {
          $tagname = $this -> htmlElementName ($r);

          $is_open_tag = (substr ($tagname, 0, 1) != '/');

          if (!$is_open_tag) {
            $tagname = substr ($tagname, 1);
          }

          if (strstr (' '. @$this->configuration->htmlElementsIgnore .' ', ' '. $tagname .' ')) {

            if ($thisfrag['content'] !== '') {
              $this->fragments[] = $thisfrag;
              if (self::N2_DEBUG) {
                $this->stream_log[] = ['frag', $thisfrag, 'HTML tag started'];
              }
            }
            $prev_strength = $thisfrag['strength'];
            $thisfrag = ['content' => $r, 'strength' => '9.sacred'];
            $this->fragments[] = $thisfrag;
            if (self::N2_DEBUG) {
              $this->stream_log[] = ['frag', $thisfrag, 'ignored tag'];
            }
            $thisfrag = ['content' => '', 'strength' => $prev_strength];
            $r = '';

          } elseif ($is_open_tag) {

            // if (self::N2_DEBUG) {
            // $this->stream_log[] = ['text', 'tag '. $tagname];
            // }
  
            if (
              $this -> elementStrength ($tagname) > $thisfrag['strength']
            ) {

              // new fragment is stronger,
              // so commit this fragment to fragments, start a new fragment
              if ($thisfrag['content'] !== '') {
                $this->fragments[] = $thisfrag;
                if (self::N2_DEBUG) {
                  $this->stream_log[] = ['frag', $thisfrag, 'new fragment is stronger'];
                }
              }
              $thisfrag = ['content' => $r, 'strength' => -1];
  
            } else {

              if ($tagname == 'img') {
                if (@$this->configuration->htmlImgDetect) {
                  if (preg_match (
                    '/\ssrc\=\"(?!.*?\:\/\/)(.*?)\"/i',
                    $r,
                    $matches
                  )) {
                    $this -> resourceDetected ($matches[1]);
                  }
                }
                if (@$this->configuration->htmlImgSrcPrefix) {
                  $r = preg_replace (
                    '/(\s)src\=\"(?!\/|.*?\:\/\/)/i',
                    (
                      '$1src="'.
                      $this->configuration->baseUrl .
                      $this->configuration->htmlImgSrcPrefix
                    ),
                    $r
                  );
                }
              }

              $thisfrag['content'] .= $r;
              //$thisfrag['content'] .= $this->isolate ($r);
  
            }
  
            $tagstack[] = $tagname;
            $current_el = $tagname;
            $r = '';
  
          } else {
  
            // close tag
                          
            if (in_array ($tagname, $tagstack)) {

              // so tag is in stack, so we force close it
              $strength_before = $this -> elementStrength ($tagname);
              while (($popping_el = array_pop ($tagstack)) != $tagname) {
                $strength_before = max ($strength_before, $this -> elementStrength ($popping_el));
              };

              // if anything remains in the stack, that’s new current tag
              if (count ($tagstack) > 0) {
                $current_el = $tagstack [count ($tagstack) - 1];
              } else {
                $current_el = '';
              }

              if ($this -> elementStrength ($current_el) < $strength_before) {
  
                // so we are now off sacred elements, 
                // so finish and append this fragment, start new fragment
                $thisfrag['content'] .= $r ."\n";
                //$thisfrag['content'] .= $this -> isolate ($r);
                $this->fragments[] = $thisfrag;
                if (self::N2_DEBUG) {
                  $this->stream_log[] = ['frag', $thisfrag, 'new fragment is weaker'];
                }
                $thisfrag = ['content' => '', 'strength' => -1];
                $r = '';
  
              }
  
            } else {
  
              if (
                strstr (' '. $this->configuration->htmlElementsSacred .' ', ' '. $tagname .' ') or
                strstr (' '. $this->configuration->htmlElementsOpaque .' ', ' '. $tagname .' ')
              ) {
  
                // closing tag makes no sense, it wasn’t open
  
                // so end whatever fragments we have
                if ($thisfrag['content'] !== '') {
                  $this->fragments[] = $thisfrag;
                  if (self::N2_DEBUG) {
                    $this->stream_log[] = ['frag', $thisfrag, 'close no tag'];
                  }
                }
  
                // make a new sacred fragment of this weird tag
                $this->fragments[] = [
                  'content' => $r,
                  'strength' => '9.sacred',
                ];
                if (self::N2_DEBUG) {
                  $this->stream_log[] = ['frag', [], 'weird'];
                }
  
                // and start new fragment
                $thisfrag = ['content' => '', 'strength' => -1];
                $r = '';
              }
            }
          }
  
        }
      }
  
      $prevstate = $state;
  
    }
  
    $thisfrag['content'] .= $r;
    if ($thisfrag['strength'] == -1) {
      $thisfrag['strength'] = $this -> elementStrength ($current_el);
    }
    $r = '';
  
    if ($thisfrag['content'] !== '') {
      $this->fragments[] = $thisfrag;
      if (self::N2_DEBUG) {
        $this->stream_log[] = ['frag', $thisfrag, 'remaining fragment'];
      }
    }
  
  }


  public function run () {

    if ($this->has_run) return;

    $this->has_run = true;

    $last_mb_encoding = mb_internal_encoding ();
    mb_internal_encoding ('utf-8');

    $this->input = str_replace ("\r\n", "\n", $this->input); 
    $this->input = str_replace ("\r", "\n", $this->input); 

    // remove html if necessary
    if (!$this->configuration->htmlOn) {
      $this->input = str_replace ('<', '&lt;', $this->input);
      // $this->input = str_replace ('>', '&gt;', $this->input);
    }

    $this -> streamToFragments ();

    foreach ($this->fragments as $i => $no_need) {

      $this->fragments[$i]['content.original'] = $this->fragments[$i]['content'];

      if (array_key_exists ('code', $this->fragments[$i]) and $this->fragments[$i]['code']) {
        $this->fragments[$i]['strength'] .= '.code';
      }

      // markup fragments should be formatted
      if ($this->fragments[$i]['strength'] === '0.markup') {

        if ($this->configuration->groupsOn) {

          $groups = $this -> groups ($this->fragments[$i]['content']);

          foreach ($groups as $group) {

            if ($group['class'] !== 'empty') {
            // echo $group['class'];
// if ($group['class'] === 'List') {
// // var_dump($this->extensions[$group['class'] .'Interpreter']['instance']);
// echo (int) method_exists ($this->extensions[$group['class'] .'Interpreter']['instance'], 'interpret');
// die;
// };
              $interpreterClass = $group['class'] .'Interpreter';
              if (
                isset ($this->extensions[$interpreterClass]) and
                method_exists ($this->extensions[$interpreterClass]['instance'], 'interpret')
              ) {
                $interpretation = $this->extensions[$interpreterClass]['instance'] -> interpret (
                  $group['lines'],
                  (array) @$this->configuration->extensions[$group['class']]
                );

                $this->model -> addElement ([
                  $group['class'], $interpretation
                ], ['srcfrag' => $i]);

              } else {

                // old-style uninterpreted group
                $this->model -> addGroupElement (
                  $group['class'],
                  $group['lines'],
                  ['srcfrag' => $i]
                );

              }

            }

            for ($j = 0; $j < (int) @$group['quote_level_inc']; ++ $j) {
              $this->model -> addRawElement (
                '<blockquote>'."\n" , ['srcfrag' => $i]
              );
            }

            for ($j = 0; $j < (int) @$group['quote_level_dec']; ++ $j) {
              $this->model -> addRawElement (
                '</blockquote>'."\n" , ['srcfrag' => $i]
              );
            }

          }

        } else {

          $this->fragments[$i]['strength'] = '7.opaque';

        }

      }

      // opaque fragments should only be typographed
      if ($this->fragments[$i]['strength'] === '7.opaque') {
        $this->model -> addOpaqueElement (
          $this->fragments[$i]['content'],
          ['srcfrag' => $i]
        );
      }

      // sacred fragments should be left as is
      if ($this->fragments[$i]['strength'] === '9.sacred') {
        $this->model -> addRawElement (
          $this->fragments[$i]['content'],
          //  ."\n", // put as many whitespace as there were after sacred
          ['srcfrag' => $i]
        );
      }
      
      // sacred fragments should be left as is
      if ($this->fragments[$i]['strength'] === '9.sacred.code') {
        $this->model -> addCodeElement (
          $this->fragments[$i]['content'],
          //  ."\n", // put as many whitespace as there were after sacred
          $this->fragments[$i]['lang'],
          ['srcfrag' => $i]
        );
        if (is_array ($this->configuration->htmlCodeRequireLinks)) {
          foreach ($this->configuration->htmlCodeRequireLinks as $link) {
            $this -> requireLink ($link);
          }
        }
      }
      
    }

    mb_internal_encoding ($last_mb_encoding);

  }


  public function getConfiguration () {

    return $this->configuration;
    
  }


  public function getModel () {

    $this -> run ();
    return $this->model;

  }

}


?>