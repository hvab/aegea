<?php

// List Interpreter Extension Version 1 for Neasden 3
// Legacy implementation with fake interpretation

namespace Neasden;

class AeOldListInterpreter implements InterpreterExtension {

  function __construct ($neasden) {
  
    if (!($chars_ul_items = $neasden -> getConfiguration () -> groupsListsChars)) {
      $chars_ul_items = ['-', '*'];
    }
    
    $ul_item_regex = array ();
    foreach ($chars_ul_items as $item) {
      $ul_item_regex[] = '(\\'. $item .' (?:$|[^'. $item .'].*))';
    }
    $ul_item_regex = implode ('|', $ul_item_regex);
    
    $neasden -> defineLineClass ('ol-item', '([1234567890]+)\.(?:$| +.*)');
    $neasden -> defineLineClass ('ul-item', $ul_item_regex);
    
    $neasden -> defineGroup ('AeOldList', '(((-ol-item-)|(-ul-item-))(-p-)*)+');
    
  }

  public function interpret ($group, $myconf) {
    return $group;
  }
  
}

?>