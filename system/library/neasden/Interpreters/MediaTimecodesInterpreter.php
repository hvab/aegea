<?php

namespace Neasden;

class MediaTimecodesInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;

    $timecode_regex = '((?:\d+\:)?\d{1,2}\:\d{2})';

    $this->neasden -> defineLineClass (
      'media-timecode',
      '(?:'. $timecode_regex .' +)(?:'. $timecode_regex .' +)?(.+)'
    );

  }
  
  public function interpret ($group, $myconf) {
    
    // not used; interpreted by the parent interpreter

  }

}

?>