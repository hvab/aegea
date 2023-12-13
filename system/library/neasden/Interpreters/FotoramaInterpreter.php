<?php

namespace Neasden;

class FotoramaInterpreter implements InterpreterExtension {

  private $neasden = null;
  
  function __construct ($neasden) {
    $this->neasden = $neasden;

    $neasden->requireLineClass ('Picture');
    $neasden->defineLineClass ('fotorama-thumbs', '(?:\[thumbs\])(.*)');

    $neasden->defineGroup ('Fotorama', '(-Picture-){2,}(-fotorama-thumbs-)?(-p-)*');
  }

  public function interpret ($group, $myconf) {

    $this->neasden -> requireLink ('jquery/jquery.js');
    $this->neasden -> requireLink ('fotorama/fotorama.css');
    $this->neasden -> requireLink ('fotorama/fotorama.js');
    
    foreach ($group as $line) {
      if ($line['class'] == 'Picture') {
        @list ($filebasename, ) = explode (' ', $line['content'], 2);  
        $this->neasden -> resourceDetected ($filebasename);
      }
    }

    return $group;
    
  }
  
}


?>