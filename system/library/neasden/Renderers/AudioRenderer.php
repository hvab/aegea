<?php

namespace Neasden;

class AudioRenderer implements RendererExtension {

  private $neasden = null;

  function __construct ($neasden) {
    $this->neasden = $neasden;
  }
  
  public function render ($interpretation, $myconf) {

    $css_class = $this->neasden-> getConfiguration () -> groupsGenericCssClass;
    if (@$myconf['css-class']) $css_class = @$myconf['css-class'];
    
    $result = '<div class="'. $css_class .'">'."\n";

    // $downloadstr = 'Download';
    // if ($this->neasden-> getConfiguration () -> language == 'ru') $downloadstr = 'Скачать';

    $jouele_data_length_attr = '';

    if ($interpretation['type'] === 'local-audio') {

      $filebasename = $interpretation['source'];
      $alt = $interpretation['alt'];
      if (!$alt) $alt = basename ($filebasename);

      // $this->neasden -> resourceDetected ($filebasename); moved to interpreter
      $filename = (
        $this->neasden -> getConfiguration () -> pathMedia .
        $myconf['folder'] .
        $filebasename
      );
      
      if (array_key_exists ('mp3info-path', $myconf)) {
        try {
          require_once $myconf['mp3info-path'];
          $audio = new \wapmorgan\Mp3Info\Mp3Info ($filename);
          $jouele_data_length_attr = 'data-length="'. floor ($audio->duration) . '" ';          
        } catch (\Exception $e) {}
      }

      $href = (
        $this->neasden -> getConfiguration () -> baseUrl .
        $myconf['src-prefix'] .
        $filebasename
      );

    }
  
    if ($interpretation['type'] === 'remote-audio') {

      $href = $interpretation['source'];
      $alt = $interpretation['alt'];
      if (!$alt) $alt = basename ($href);

    }

    $player_html = '<div class="e2-text-super-wrapper e2-jouele-wrapper"><a '.
      'class="jouele" '.
      'data-space-control="true" '.
      $jouele_data_length_attr.
      'href="'. $href .'"'.
    '>'. $alt .'</a></div>';

    $result .= $player_html ."\n";

    if (array_key_exists ('timecodes', $interpretation)) {

      $rendererClass = 'MediaTimecodesRenderer';
      $result .= $this->neasden->extensions[$rendererClass]['instance'] -> render (
        $interpretation,
        $myconf // bugbug, should be MediaTimecodesInterpreter conf
      );

    }

    // code duplication with onlinevideo.php, video.php :-(
    if (0 and count ($ranges)) {

      if ($this->neasden -> getConfiguration () -> htmlBasic) {
        
        $result .= '<p>'."\n";
        foreach ($ranges as $range) {
          $item = [
            'from' => $range[1],
            'title' => $range[3],
          ];
          $result .= $item['from'] .' '. $item['title'] .'<br />'."\n";
        }
        $result .= '</p>'."\n";

      } else {  

        $result .= '<div class="e2-media-sections">'."\n";
        $result .= '<table cellpadding="0" cellspacing="0" border="0">'."\n";
        foreach ($ranges as $range) {
          $item = [
            'from' => $range[1],
            'to' => $range[2],
            'title' => $range[3],
          ];
          $result .= '<tr class="jouele-control e2-media-sections-item" data-type="seek" '."\n";
          $result .= 'data-range="'. $item['from'] .'...'. $item['to'] .'" '."\n";
          $result .= 'data-href="'. $href .'">'."\n";
          $result .= '<td style="width: 1px; white-space: nowrap"><span>'. $item['from'] .'</span></td>'."\n";
          $result .= '<td class="e2-media-sections-item-title"><span>'. $item['title'] .'</span></td>'."\n";
          $result .= '</tr>'."\n";
        }
        $result .= '</table>'."\n";
        $result .= '</div>'."\n";

      }

    }

    $result .= '</div>'."\n";
  
    return $result;
    
  }
  
}

?>