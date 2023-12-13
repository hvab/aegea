<?php

namespace Neasden;

class AudioInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;

    $this->neasden -> defineLineClass ('Audio', '.*\.(mp3)(?: +(.+))?');
    $this->neasden -> defineLineClass ('audio-play', '(?:\[play\])(.*)');
    $this->neasden -> requireLineClass ('media-timecode');

    $this->neasden -> defineGroup ('Audio', '(?:(-Audio-)|(-audio-play-))(-media-timecode-)*');
  }

  function detectLine ($line, $myconf) {
    list ($filebasename, ) = explode (' ', $line, 2);  
    return is_file (
      $this->neasden -> getConfiguration () -> pathMedia .
      $myconf['folder'] .
      $filebasename
    );
  }
  
  public function interpret ($group, $myconf) {

    $this->neasden -> requireLink ('jquery/jquery.js');
    $this->neasden -> requireLink ('jouele/jouele.css');
    $this->neasden -> requireLink ('jouele/jouele.js');

    $interpretation = [];

    foreach ($group as $line) {

      if ($line['class'] === 'Audio') {
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);
        $alt = trim ((string) $alt);
        $this->neasden -> resourceDetected ($filebasename);
        $interpretation = [
          'type' => 'local-audio',
          'source' => $filebasename,
          'alt' => $alt,
        ];
      }

      if ($line['class'] === 'audio-play') {
        @list ($href, $alt) = explode (' ', trim ($line['class-data'][1]), 2);
        $alt = trim ((string) $alt);
        $this->neasden -> resourceDetected ($href);
        $interpretation = [
          'type' => 'remote-audio',
          'source' => $href,
          'alt' => $alt,
        ];
      }

      if ($line['class'] === 'media-timecode') {  
        $interpretation['timecodes'][] = [
          'from' => $line['class-data'][1],
          'to' => $line['class-data'][2],
          'title' => $line['class-data'][3],
        ];
      }

    }

    return $interpretation;

  }

}

?>