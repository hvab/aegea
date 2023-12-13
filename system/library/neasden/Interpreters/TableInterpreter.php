<?php

namespace Neasden;

class TableInterpreter implements InterpreterExtension {

  function __construct ($neasden) {

    $neasden->requireLineClass ('hr');
    $neasden->defineLineClass ('tr', '\|([^\|]+\|)+');
    
    $neasden->defineGroup ('Table', '(-hr-)(-tr-)+(-hr-)?');
    
  }

  public function interpret ($group, $myconf) {

    $interpretation = [];

    foreach ($group as $line) if ($line['class'] == 'tr') {

      $tr = explode ('|', trim ($line['content'], '|'));
      $row = [];
      
      foreach ($tr as $td) {

        $cell = [];
        
        $lsp = (mb_substr ($td, 0, 1) == ' ');
        $rsp = (mb_substr ($td, -1)   == ' ');
        
        if     ($lsp and $rsp)  $alignment = 'center';
        elseif ($lsp)           $alignment = 'right';
        elseif ($rsp)           $alignment = 'left';
        else                    $alignment = '';


        if ($alignment) {
          $cell['content'] = trim ($td);
          $cell['alignment'] = $alignment;
        } else {
          $cell = trim ($td);
        }
        
        $row[] = $cell;

      }

      $interpretation[] = $row;

    }
  
    return $interpretation;
    
  }
  
}

?>