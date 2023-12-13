<?php

namespace Neasden;

class HRRenderer implements RendererExtension {

  public function render ($interpretation, $myconf) {

    return "<hr />\n";

  }
  
}


?>