<?php

namespace Neasden;

class TableRenderer implements RendererExtension {

  public function render ($interpretation, $myconf) {
  
    $result = '<table cellpadding="0" cellspacing="0" border="0" class="'. $myconf['css-class'] .'">' ."\n";

    foreach ($interpretation as $row) {
      $result .= "<tr>\n";
      foreach ($row as $cell) {

        $content = $cell;
        $alignment = '';

        if (is_array ($cell)) {
          $content = $cell['content'];
          $alignment = $cell['alignment'];
        }
        
        if ($alignment) $alignment = ' style="text-align: '. $alignment .'"';
        
        $result .= "<td". $alignment .">". $content ."</td>\n";
        
      }
      $result .= "</tr>\n";
    }
  
    $result .= "</table>\n";
    
    return $result;
    
  }
  
}

?>