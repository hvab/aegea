<?php

class NeasdenGroup_audio implements NeasdenGroup {
  
  private $neasden = null;

  function __construct ($neasden) {
    $this->neasden = $neasden;

    $neasden->define_line_class ('audio', '.*\.(mp3)(?: +(.+))?');
    $neasden->define_line_class ('audio-play', '(?:\[play\])(.*)');
    $neasden->define_group ('audio', '(?:(-audio-)|(-audio-play-))');
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
    
    foreach ($group as $line) {
    
      if ($line['class'] == 'audio') {
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);
        $this->neasden->resource_detected ($filebasename);
        if (!$alt) $alt = basename ($filebasename);
        $href = $myconf['src-prefix'] . $filebasename;
      }
  
      if ($line['class'] == 'audio-play') {
        @list ($href, $alt) = explode (' ', trim ($line['class-data'][1]), 2); // usafe
        if (!$alt) $alt = basename ($href);
      }
    
      if ($line['class'] == 'audio' or $line['class'] == 'audio-play') {
  
        $player_html = '<a '.
          'class="jouele" '.
          'data-space-control="true" '.
          'href="'. $href .'" '.
        '>'. $alt .'</a>'."\n";
        
        $player_html = $this->neasden->isolate ($player_html);

        $result .= $player_html;
      
      }
      
    }
  
    $result .= '</div>'."\n";
  
    return $result;
    
  }
  
}

?>