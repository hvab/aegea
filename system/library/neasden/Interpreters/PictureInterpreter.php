<?php

namespace Neasden;

class PictureInterpreter implements InterpreterExtension {

  private $neasden = null;
  
  function __construct ($neasden) {

    $this->neasden = $neasden;

    $this->neasden -> defineLineClass ('Picture', '.*\.(jpe?g|gif|png|webp|svg)(?: +(.+))?');

    $this->neasden -> defineGroup ('Picture', '(-Picture-)(-p-)*');

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

      if ($line['class'] === 'Picture') {
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);  
        $alt = trim ((string) $alt);
      
        // check if alt starts with an url
        @list ($link, $newalt) = explode (' ', $alt, 2);
        $newalt = trim ((string) $newalt);
        if (preg_match ('/[a-z]+\:.+/i', $link)) {
          $alt = $newalt;
        } else {
          $link = '';
        }

        $this->neasden -> resourceDetected ($filebasename);
        $interpretation = [
          'type' => 'local-image',
          'source' => $filebasename,
          'alt' => $alt,
          'link' => $link,
        ];
      }

      if ($line['class'] === 'p') {
        $caption_lines_content[] = $line['content'];
      }

    }


    if (count ($caption_lines_content)) {
      $interpretation['caption'] = implode ("\n", $caption_lines_content);
    }

    return $interpretation;

  }
  
}

?>
