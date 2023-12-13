<?php

namespace Neasden;

class HRInterpreter implements InterpreterExtension {

  function __construct ($neasden) {

    $neasden -> defineLineClass ('hr', '[-–—]{5,}');

    $neasden -> defineGroup ('HR', '(-hr-)');

  }

  public function interpret ($group, $myconf) {

    return [];

  }
  
}


?>