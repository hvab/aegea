<?php

namespace Neasden;

class OnlineVideoRenderer implements RendererExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;

  }
  
  public function render ($interpretation, $myconf) {

    $result = '<div class="'. $myconf['css-class'] .'">'."\n";

    $max_width = $myconf['max-width'];
    $ratio = $myconf['ratio'];

    // $interpretation['source']; // ???

    if ($interpretation['service'] === 'youtube') {
      // enablejsapi=1 is required to be able to manipulate this video through YouTube Iframe API:
      // https://developers.google.com/youtube/iframe_api_reference#Example_Video_Player_Constructors
      $src = 'https://www.youtube.com/embed/'. $interpretation['id'] .'';
      // $this->neasden -> resourceDetected ($src); moved to Interpreter
      $src .= '?enablejsapi=1';
      // check resources.php for www.youtube.com, this is important
    }

    if ($interpretation['service'] === 'vimeo') {
      $src = 'https://player.vimeo.com/video/'. $interpretation['id'] .''; //?title=0&amp;byline=0&amp;portrait=0
      // $this->neasden -> resourceDetected ($src); moved to Interpreter
      // check resources.php for player.vimeo.com, this is important
    }

    if ($this->neasden -> getConfiguration () -> htmlBasic) {

      // allow="autoplay" here allows to play videos using JS when user clicks on a timestamp
      $iframe_html = '<iframe src="'. $src .'" allow="autoplay" frameborder="0" allowfullscreen></iframe>';

    } else {

      // wrap into upyachka fix
      $iframe_html = (
        '<div class="e2-text-super-wrapper" style="width: '. $max_width .'px; max-width: 100%">'.
        '<div class="e2-text-proportional-wrapper" style="'.
        'padding-bottom: '. round (100 / $ratio, 2).'%'.
        '">'.
        '<iframe width="100%" height="100%" style="position: absolute" '.
        // allow="autoplay" here allows to play videos using JS when user clicks on a timestamp
        'src="'. $src .'" frameborder="0" allowfullscreen allow="autoplay"> '.
        '</iframe>'.
        '</div>'.
        '</div>'
      );

    }

    $result .= $iframe_html ."\n";
      
    if (array_key_exists ('caption', $interpretation)) {
      $result .= '<div class="e2-text-caption">'; // compatibility
      // $result .= '<div class="e2-text-caption">'."\n";
      $result .= str_replace ("\n", '<br />'."\n", $interpretation['caption']);
      $result .= '</div>'."\n";
    }  
  
    if (array_key_exists ('timecodes', $interpretation)) {

      $rendererClass = 'MediaTimecodesRenderer';
      $result .= $this->neasden->extensions[$rendererClass]['instance'] -> render (
        $interpretation,
        $myconf // bugbug, should be MediaTimecodesInterpreter conf
      );

    }

    $result .= '</div>'."\n";
  
    return $result;
    
  }
  
}

?>
