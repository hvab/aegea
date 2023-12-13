<?php

// use Mp4Info;

namespace Neasden;

class VideoRenderer implements RendererExtension {

  private $neasden = null;
  
  function __construct ($neasden) {

    $this->neasden = $neasden;

  }

  public function render ($interpretation, $myconf) {

    $result = '<div class="'. $myconf['css-class'] .'">'."\n";

    $filebasename = $interpretation['source'];
    $alt = $interpretation['alt'];
    
    // check if alt start with an url
    @list ($link, $newalt) = explode (' ', $alt, 2);
    if (preg_match ('/[a-z]+\:.+/i', $link)) {
      $alt = $newalt;
    } else {
      $link = '';
    }
    
    // $this->neasden -> resourceDetected ($filebasename); moved to interpreter
    
    $filename = (
      $this->neasden -> getConfiguration () -> pathMedia .
      $myconf['folder'] .
      $filebasename
    );
    $pathinfo = pathinfo ($filename);
    
    $width = $height = $ratio = 0;

    try {
      require_once $myconf['getid3-path'];
      $info = new \getid3 ();
      $info = @$info -> analyze ($filename); // may have a divbyzero inside
      $width = $info['video']['resolution_x'];
      $height = $info['video']['resolution_y'];
    } catch (\Exception $e) {}

    $filebasename_modifiers = substr ($filebasename, 0, strrpos ($filebasename, '.')) . '@"';

    if (strstr ($filebasename_modifiers, '@2x@')) {
      $width /= 2;
      $height /= 2;
    }

    $attrs = 'controls';
    if (strstr ($filebasename_modifiers, '@loop@')) {
      $attrs = 'autoplay muted loop playsinline';
    }

    $filename_original = $filename;
    $width_original = $width;
    // image too wide
    if ($width > $myconf['max-width']) {
      $height = $height * ($myconf['max-width'] / $width);
      $width = $myconf['max-width'];  
    }

    if ($width) $ratio = $height / $width;
    
    $video_html = (
      // '<img src="'. $myconf['src-prefix'] . $filebasename .'" '.
      // 'width="'. $width .'" height="'. $height.'" '.
      // 'alt="'. htmlspecialchars ($alt) .'" />'. "\n"
      '<video src="'. (
        $this->neasden -> getConfiguration () -> baseUrl .
        $myconf['src-prefix'] .
        $filebasename
      ) .'#t=0.001" '.
      'width="'. $width .'" height="'. $height.'" '.
      $attrs .' '.
      'alt="'. htmlspecialchars ($alt) .'" />'. "\n"
    );

    if (! $this->neasden -> getConfiguration () -> htmlBasic) {
      // wrap into upyachka fix
      $video_html = (
        '<div class="e2-text-super-wrapper" style="width: '. $width .'px; max-width: 100%">'.
        '<div class="e2-text-proportional-wrapper" style="'.
        'padding-bottom: '. @round ($ratio * 100, 2).'%'.
        '">'.
        $video_html.
        '</div>'.
        '</div>'
      );
    }

    // wrap into a link to URL if needed
    $cssc_link = $myconf['css-class'] .'-link';
    if ($link) {
      $video_html = (
        // width="'. $width_original .'"
        // style="width: '. $width_original .'px"
        '<a href="'. $link .'" class="'. $cssc_link .'">' ."\n".
        $video_html .
        '</a>'
      );
    }

    $result .= $video_html ."\n";

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
