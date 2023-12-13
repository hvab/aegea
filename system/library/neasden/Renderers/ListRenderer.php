<?php

// List Extension Version 2 for Neasden 3

namespace Neasden;

class ListRenderer implements RendererExtension {

  private $neasden = null;

  private $depth = 0;
  
  function __construct ($neasden) {

    $this->neasden = $neasden;

  }

  public function render ($interpretation, $myconf) {

    $depth_spacing = str_repeat (' ', $this->depth * (int) @$myconf['html-depth-spaces']);

    $result = '';

    $start_attr = '';
    if (array_key_exists ('start', $interpretation)) {
      $start_attr = ' start="'. $interpretation['start'] .'"';
    }

    $list_tag = ($interpretation['kind'] === 'o' ? ('ol'. $start_attr) : 'ul');
    $result .= $depth_spacing . "<". $list_tag .">\n";

    ++ $this->depth;
    $depth_spacing = str_repeat (' ', $this->depth * (int) @$myconf['html-depth-spaces']);

    foreach ($interpretation['items'] as $item) {

      if (is_string ($item)) {
        $item = ['content' => $item];
      }

      $result .= $depth_spacing .'<li>';
      $result .= str_replace ("\n", '<br />'."\n". $depth_spacing, $item['content']);

      if (array_key_exists ('sublist', $item)) {
        $result .= "\n";
        ++ $this->depth;
        $result .= $this -> render ($item['sublist'], $myconf);
        -- $this->depth;
        $result .= $depth_spacing .'</li>'."\n";
      } else {
        $result .= '</li>'."\n"; // same line
      }

    }

    -- $this->depth;
    $depth_spacing = str_repeat (' ', $this->depth * (int) @$myconf['html-depth-spaces']);

    $list_tag = ($interpretation['kind'] === 'o' ? 'ol' : 'ul');
    $result .= $depth_spacing . "</". $list_tag .">\n";

    return $result;

  }
  
}


?>