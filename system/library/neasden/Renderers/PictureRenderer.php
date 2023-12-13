<?php

namespace Neasden;

class PictureRenderer implements RendererExtension {

  private $neasden = null;
  
  function __construct ($neasden) {
    $this->neasden = $neasden;
  }
    
  public function render ($interpretation, $myconf) {
  
    $result = '<div class="'. $myconf['css-class'] .'">'."\n";

    $filebasename = $interpretation['source'];
    $alt = $interpretation['alt'];
    $link = $interpretation['link'];

    $filename = (
      $this->neasden -> getConfiguration () -> pathMedia .
      $myconf['folder'] .
      $filebasename
    );
    $pathinfo = pathinfo ($filename);
    
    $width = $height = $ratio = 0;

    if ($pathinfo['extension'] == 'svg') {
      // echo $filename;
      $xmlget = simplexml_load_string (file_get_contents ($filename));
      if ($xmlget) {
        $xmlattributes = $xmlget -> attributes ();
        list ($width, $height) = array ((string) $xmlattributes -> width, (string) $xmlattributes -> height);
        if (!$width) $width = $myconf['max-width'];
        if (!$height) $height = $myconf['max-width'];
      }
    } elseif ($size = e2_getimagesize ($filename)) {
      // $size = false;
      // sometimes it comes as false and breaks everything :-(
      if ($size === false) throw new \Exception ();
      list ($width, $height) = $size;
    }

    // image too wide
    if (is_int (@$myconf['max-width']) and $width > $myconf['max-width']) {
      $height = $height * ($myconf['max-width'] / $width);
      $width = $myconf['max-width'];  
    }

    if ($width) $ratio = $height / $width;
    
    $image_html = (
      '<img src="'. (
        $this->neasden -> getConfiguration () -> baseUrl .
        $myconf['src-prefix'] .
        $filebasename
      ) .'" '.
      'width="'. $width .'" height="'. $height.'" '.
      'alt="'. htmlspecialchars ($alt) .'" />'. "\n"
    );

    if (! $this->neasden -> getConfiguration () -> htmlBasic) {
      // wrap into upyachka fix
      $image_html = (
        '<div style="width: '. $width .'px; max-width: 100%">'.
        '<div class="e2-text-proportional-wrapper" style="'.
        'padding-bottom: '. round ($ratio * 100, 2).'%'.
        '">'.
        $image_html.
        '</div>'.
        '</div>'
      );
    }

    // wrap into a link to URL if needed
    $cssc_link = $myconf['css-class'] .'-link';
    if ($link) {
      $image_html = (
        '<a href="'. $link .'" class="'. $cssc_link .'">' ."\n".
        $image_html .
        '</a>'
      );
    }

    $result .= $image_html;
      
    if (array_key_exists ('caption', $interpretation)) {
      $result .= '<div class="e2-text-caption">'; // compatibility
      // $result .= '<div class="e2-text-caption">'."\n";
      $result .= str_replace ("\n", '<br />'."\n", $interpretation['caption']);
      $result .= '</div>'."\n";
    }  
  
    $result .= '</div>'."\n";
    
    return $result;
    
  }
  
}

?>