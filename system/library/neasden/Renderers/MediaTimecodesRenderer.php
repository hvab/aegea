<?php

namespace Neasden;

class MediaTimecodesRenderer implements RendererExtension {

  private $neasden = null;
  
  function __construct ($neasden) {

    $this->neasden = $neasden;

  }

  public function render ($interpretation, $myconf) {

    $result = '';

    $timecodes = $interpretation['timecodes'];

    if (!is_array ($timecodes)) return $result;
    if (!count ($timecodes)) return $result;

    if ($this->neasden -> getConfiguration () -> htmlBasic) {
      
      $result .= '<p>'."\n";
      foreach ($timecodes as $timecode) {
        if (array_key_exists ('timecode', $timecode)) {
          $result .= $timecode['timecode'] .' '. $timecode['title'] .'<br />'."\n";
        } elseif (array_key_exists ('from', $timecode) and array_key_exists ('to', $timecode)) {
          $result .= $timecode['from'] .'...'. $timecode['to'] .' '. $timecode['title'] .'<br />'."\n";
        }
      }
      $result .= '</p>'."\n";

    } else {

      $href = $interpretation['source'];
      
      if (parse_url ($href, PHP_URL_SCHEME) === null) {
        $href = (
          $this->neasden -> getConfiguration () -> baseUrl .
          (string) @$myconf['src-prefix'] 
        ). $interpretation['source'];
      }

      $result .= '<div class="e2-media-sections">'."\n";
      $result .= '<table cellpadding="0" cellspacing="0" border="0">'."\n";
      foreach ($timecodes as $timecode) {

        if (
          $interpretation['type'] === 'local-audio' or
          $interpretation['type'] === 'remote-audio'
        ) {
          $result .= '<tr class="jouele-control e2-media-sections-item" data-type="seek" '."\n";
        } else {
          $result .= '<tr class="e2-media-control e2-media-sections-item" data-type="seek" '."\n";
        }

        if (array_key_exists ('timecode', $timecode)) {
          $result .= 'data-to="'. $timecode['timecode'] .'" '."\n";
        }

        if (array_key_exists ('from', $timecode) and array_key_exists ('to', $timecode)) {
          $result .= 'data-range="'. $timecode['from'] .'...'. $timecode['to'] .'" '."\n";
        }

        $result .= 'data-href="'. $href .'">'."\n";

        if (array_key_exists ('timecode', $timecode)) {
          $result .= '<td style="width: 1px; white-space: nowrap"><span>'. $timecode['timecode'] .'</span></td>'."\n";
        }

        if (array_key_exists ('from', $timecode) and array_key_exists ('to', $timecode)) {
          $result .= '<td style="width: 1px; white-space: nowrap"><span>'. $timecode['from'] .'</span></td>'."\n";
        }

        $result .= '<td class="e2-media-sections-item-title"><span>'. $timecode['title'] .'</span></td>'."\n";

        $result .= '</tr>'."\n";

      }
      $result .= '</table>'."\n";
      $result .= '</div>'."\n";

    }
      
    return $result;

  }
  
}


?>