<?php

use wapmorgan\Mp3Info\Mp3Info;

class NeasdenGroup_audio implements NeasdenGroup {
  
  private $neasden = null;

  function __construct ($neasden) {
    $this->neasden = $neasden;

    $neasden->define_line_class ('audio', '.*\.(mp3)(?: +(.+))?');
    $neasden->define_line_class ('audio-play', '(?:\[play\])(.*)');
    $neasden->define_line_class ('audio-range-title', '(?:(.+) (.+)  (.+))');
    $neasden->define_group ('audio', '(?:(-audio-)|(-audio-play-))(-audio-range-title-)*');
  }

  function detect_line ($line, $myconf) {
    list ($filebasename, ) = explode (' ', $line, 2);  
    return is_file ($myconf['folder'] . $filebasename);
  }
  
  function render ($group, $myconf) {

    $this->neasden->require_link (@$this->neasden->config['library']. 'jquery/jquery.js');
    $this->neasden->require_link (@$this->neasden->config['library']. 'jouele/jouele.css');
    $this->neasden->require_link (@$this->neasden->config['library']. 'jouele/jouele.js');
    
    $css_class = $this->neasden->config['groups.generic-css-class'];
    if (@$myconf['css-class']) $css_class = @$myconf['css-class'];
    
    $downloadstr = 'Download';
    if ($this->neasden->config['language'] == 'ru') $downloadstr = 'Скачать';
  
    $result = (
      '<div class="'. $css_class .'">'."\n"
    );

    $ranges = [];
    
    foreach ($group as $line) {
    
      if ($line['class'] == 'audio') {
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);
        $this->neasden->resource_detected ($filebasename);
        if (!$alt) $alt = basename ($filebasename);
        $filename = $myconf['folder'] . $filebasename;
        
        $jouele_data_length_attr = '';
        try {
          require_once @$this->neasden->config['library'] .'mp3info/mp3info.php';
          $audio = new Mp3Info($filename);
          $jouele_data_length_attr = 'data-length="'. floor ($audio->duration) . '" ';          
        } catch (\Exception $e) {}

        $href = $myconf['src-prefix'] . $filebasename;
      }
  
      if ($line['class'] == 'audio-play') {
        @list ($href, $alt) = explode (' ', trim ($line['class-data'][1]), 2); // usafe
        $this->neasden->resource_detected ($href);
        if (!$alt) $alt = basename ($href);
      }
    
      if ($line['class'] == 'audio' or $line['class'] == 'audio-play') {
  
        $player_html = '<a '.
          'class="jouele" '.
          'data-space-control="true" '.
          $jouele_data_length_attr.
          'href="'. $href .'" '.
        '>'. $alt .'</a>'."\n";
        
        $player_html = $this->neasden->isolate ($player_html);

        $result .= $player_html;
      
      }

      if ($line['class'] == 'audio-range-title') {
        $ranges[] = $line['class-data'];
      }
      
    }
  
    if (count ($ranges)) {
      // $result = '<div class="'. $myconf['css-class'] .'">' ."\n";
      // $result .= '<table cellpadding="0" cellspacing="0" border="0">' ."\n";
      $result .= '<div class="e2-audio-ranges">'."\r\n";
      $result .= '<table cellpadding="0" cellspacing="0" border="0">'."\r\n";
      foreach ($ranges as $range) {
        $item = [
          'from' => $range[1],
          'to' => $range[2],
          'title' => $range[3],
        ];
        $result .= '<tr class="jouele-control e2-audio-ranges-item" data-type="seek" '."\r\n";
        $result .= 'data-range="'. $item['from'] .'...'. $item['to'] .'" '."\r\n";
        $result .= 'data-href="'. $href .'">'."\r\n";
        $result .= '<td style="width: 1px; white-space: nowrap"><span>'. $item['from'] .'</span></td>'."\r\n";
        $result .= '<td class="e2-audio-ranges-item-title"><span>'. $item['title'] .'</span></td>'."\r\n";
        $result .= '</tr>'."\r\n";
      }
      $result .= '</table>'."\r\n";
      $result .= '</div>'."\r\n";
      // $result .= '<pre>';
      // $result .= print_r ($ranges, true);
      // $result .= '</pre>';
    }

    $result .= '</div>'."\n";
  
    return $result;
    
  }
  
}

?>