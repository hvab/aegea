<?php

namespace Neasden;

class VideoInterpreter implements InterpreterExtension {

  private $neasden = null;
  
  function __construct ($neasden) {
    
    $this->neasden = $neasden;

    $this->neasden -> defineLineClass ('Video', '.*\.(mp4|mov)(?: +(.+))?');
    $this->neasden -> requireLineClass ('media-timecode');

    $this->neasden -> defineGroup ('Video', '(-Video-)(?:(-p-)*|(-media-timecode-)*)');

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

    $interpretation = [];
    $caption_lines_content = [];

    foreach ($group as $line) {

      if ($line['class'] === 'Video') {  
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);
        $this->neasden -> resourceDetected ($filebasename);
        $alt = trim ((string) $alt);
        $interpretation = [
          'type' => 'local-video',
          'source' => $filebasename,
          'alt' => $alt,
        ];
      }

      if ($line['class'] === 'p') {  
        $caption_lines_content[] = $line['content'];
      }

      if ($line['class'] === 'media-timecode') {  
        $this->neasden -> requireLink ('jquery/jquery.js');
        $this->neasden -> requireLink ('media-seek/media-seek.js');

        $interpretation['timecodes'][] = [
          'timecode' => $line['class-data'][1],
          'title' => $line['class-data'][3],
        ];
      }

    }

    if (count ($caption_lines_content)) {
      $interpretation['caption'] = implode ("\n", $caption_lines_content);
    }

    return $interpretation;

  }
  
}

?>
