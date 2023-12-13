<?php

namespace Neasden;

class BlockRenderer implements RendererExtension {

  public function render ($interpretation, $myconf) {

    $line = $interpretation[0];

    $class = $line['class-data'][1];
    $content = $line['class-data'][2];

    $result = '<p class="'. $class .'">';
    $result .= $content;
    $result .= '</p>'."\n";
  
    return $result;
    
  }
  
  
}

?>