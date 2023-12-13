<?php

namespace Neasden;

class BlockInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {
    $this->neasden = $neasden;
  
    $this->neasden -> defineLineClass (
      'block',
      '^\.([a-z-_]+) (.+)'
    );

    $this->neasden -> defineGroup ('Block', '(-block-)');
  
  }

  public function interpret ($group, $myconf) {

    return $group;

  }

}

?>