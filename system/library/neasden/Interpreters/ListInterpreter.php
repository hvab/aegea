<?php

// List Interpreter Extension Version 2 for Neasden 3

namespace Neasden;

class ListInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {
    $this->neasden = $neasden;
  
    if (!($chars_ul_items = $this->neasden -> getConfiguration () -> groupsListsChars)) {
      $chars_ul_items = ['-', '*'];
    }
    
    $ul_item_regex = array ();
    foreach ($chars_ul_items as $item) {
      $ul_item_regex[] = '(\\'. $item .' (?:$|[^'. $item .'].*))';
    }
    $ul_item_regex = implode ('|', $ul_item_regex);
    
    $neasden -> defineLineClass ('ol-item', '([1234567890]+)\.(?:$| +.*)');
    $neasden -> defineLineClass ('ul-item', $ul_item_regex);
    
    $neasden -> defineGroup ('List', '(((-ol-item-)|(-ul-item-))(-p-)*)+');
    
  }

  public function interpret ($group, $myconf) {

    // depth from the engine can be anything, but
    // we assume the depth of first item as a base
    // and then if something is shallower
    // we just use the base depth:
    $group_line_number = 0;
    $line = $group[$group_line_number];
    $basedepth = $line['depth'];
    $prevdepth = 0;
    $depth = 0;
    
    // at each depth level we track list kind:
    $concept[$depth]['kind'] = ($line['class'] == 'ol-item')? 'o' : 'u';

    // an ordered list may have a start number
    if (
      $concept[$depth]['kind'] === 'o'
      and ((string) $line['class-data'][1] !== '')
    ) {
      $start_number = (int) $line['class-data'][1];
      $concept[$depth]['start'] =  $start_number;
    }
    
    // create empty list of items
    $concept[$depth]['items'] = [];
    
    foreach ($group as $group_line_number => $line) {

      if ($line['class'] === 'p') {
    
        // it can’t be the first line of group per its regex
        // it’s just a text line, so add it after item

        $prev_item_content = array_pop ($concept[$depth]['items']);
        $concept[$depth]['items'][] = (
          $prev_item_content . "\n".
          $line['content']
        );

      } else {
      
        $depth = max (0, $line['depth'] - $basedepth);

        // treat item of unexpected type as line of plain text
        if (($depth === $prevdepth) and (
          ($line['class'] === 'ol-item' and $concept[$depth]['kind'] === 'u') or
          ($line['class'] === 'ul-item' and $concept[$depth]['kind'] === 'o')
        )) {

          $prev_item_content = array_pop ($concept[$depth]['items']);
          $concept[$depth]['items'][] = (
            $prev_item_content . "\n".
            $line['content']
          );

          continue;

        }

        $item_content = null;
        $concept_item_sublist = null;

        if ($depth > $prevdepth) {

          // at each depth level we track list kind:
          $concept[$depth]['kind'] = ($line['class'] == 'ol-item')? 'o' : 'u';

          // an ordered list may have a start number
          if (
            $concept[$depth]['kind'] === 'o'
            and ((string) $line['class-data'][1] !== '')
          ) {
            $start_number = (int) $line['class-data'][1];
            $concept[$depth]['start'] =  $start_number;
          }

          // create empty list of items
          $concept[$depth]['items'] = [];

        }
    
        if ($depth < $prevdepth) {

          $concept_item_sublist = $concept[$prevdepth];
          array_pop ($concept);

        }

        $prevdepth = $depth;
    
        if ($line['class'] == 'ol-item') {
          $group_line_content_numberless = ltrim ($line['content'], '0123456789');
          $item_content = ltrim (mb_substr ($group_line_content_numberless, 1), ' ');
        } elseif ($line['class'] == 'ul-item') {
          $item_content = ltrim (mb_substr ($line['content'], 1), ' ' . $line['content'][0]);
        }

        if ($item_content !== null) {
          
          // add sublist to previous item
          if ($concept_item_sublist !== null) {
            $prev_item_content = array_pop ($concept[$depth]['items']);
            $concept[$depth]['items'][] = [
              'content' => $prev_item_content,
              'sublist' => $concept_item_sublist,
            ];
          }

          $concept[$depth]['items'][] = $item_content;

        }
 
      }
      
    }

    // remaining items

    while ($depth --) {

      $concept_item_sublist = array_pop ($concept);

      $prev_item_content = array_pop ($concept[$depth]['items']);

      $concept[$depth]['items'][] = [
        'content' => $prev_item_content,
        'sublist' => $concept_item_sublist,
      ];

      -- $prevdepth;

    }

    return $concept[0];

  }

}

?>