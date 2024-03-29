<?php

namespace Neasden;

class FotoramaRenderer implements RendererExtension {

  private $neasden = null;
  
  function __construct ($neasden) {
    $this->neasden = $neasden;
  }

  public function render ($interpretation, $myconf) {

    $result = '<div class="'. $myconf['css-class'] .'">'."\n";
    $p_opened = false;
    $div_opened = false;
    
    foreach ($interpretation as $line) {

      if ($line['class'] == 'Picture') {
    
        list ($filebasename, $alt) = explode (' ', $line['content'].' ', 2);
        $alt = trim ((string) $alt);
        
        // $this->neasden -> resourceDetected ($filebasename); moved to interpreter
        
        $filename = (
          $this->neasden -> getConfiguration () -> pathMedia .
          $myconf['folder'] .
          $filebasename
        );

        $size = e2_getimagesize ($filename);
        list ($width, $height) = $size;
    
        if ($width > $myconf['max-width']) {
          $height = $height * ($myconf['max-width'] / $width);
          $width = $myconf['max-width'];
        }
    
        $ratio = 0;
        if ($height) $ratio = $width / $height;

        $image_html = (
          '<img src="'. (
            $this->neasden -> getConfiguration () -> baseUrl .
            $myconf['src-prefix'] .
            $filebasename
          ) .'" '.
          'width="'. $width .'" height="'. $height.'" '.
          // 'data-caption="'. $alt.'" '.
          'alt="'. $alt .'" />'. "\n"
        );
        
        if (!$div_opened) {
          $result .= (
            '<div class="fotorama" '.
              'data-width="'. $width .'" '.
              'data-ratio="'. $ratio .'"'.
            '>'."\n"
          );
          $div_opened = true;
        }
    
        $result .= $image_html;

      } elseif ($line['class'] == 'fotorama-settings') {

        $settings = substr ($line['content'], 1, -1);
        if ($settings == 'thumbs') {
          $settings = 'data-nav="thumbs"';
        } else {
          $settings = str_replace ('fotorama ', '', $settings);
        }

        $result = str_replace ('class="fotorama"', 'class="fotorama" '.$settings, $result);

      } else {
        if (!$p_opened) {
          $p_opened = true;
          if ($div_opened) {
            $result .= '</div>' . "\n";
            $div_opened = false;
          }
          $result .= '<div class="e2-text-caption">' . $line['content'];
        } else {
          $result .= '<br />' . "\n" . $line['content'];
        }
      }

    }
    
    if ($p_opened) {
      $result .= '</div>'."\n";
      $p_opened = false;
    }
    
    if ($div_opened) {
      $result .= '</div>'."\n";
      $div_opened = false;
    }

    $result .= '</div>'."\n";
    
    return $result;
      
  }
  
}


?>