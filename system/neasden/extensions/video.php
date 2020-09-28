<?php

// use Mp4Info;

class NeasdenGroup_video implements NeasdenGroup {

  private $neasden = null;
  
  function __construct ($neasden) {
    $this->neasden = $neasden;

    $neasden->require_line_class ('timed-media-section');
    $neasden->define_line_class ('video', '.*\.(mp4|mov)(?: +(.+))?');
    $neasden->define_group ('video', '(-video-)(?:(-p-)*|(-timed-media-section-)*)');
  }
    
  function detect_line ($line, $myconf) {
    list ($filebasename, ) = explode (' ', $line, 2);
    return is_file ($myconf['folder'] . $filebasename);
  }  
  
  function render ($group, $myconf) {
    $this->neasden->require_link (@$this->neasden->config['library']. 'jquery/jquery.js');
    $this->neasden->require_link (@$this->neasden->config['library']. 'media-seek/media-seek.js');
  
    $p = false;
    $ranges = [];

    $result = '<div class="'. $myconf['css-class'] .'">'."\n";
    foreach ($group as $line) {
      if ($line['class'] == 'video') {
  
        @list ($filebasename, $alt) = explode (' ', $line['content'], 2);
        
        // check if alt start with an url
        @list ($link, $newalt) = explode (' ', $alt, 2);
        if (preg_match ('/[a-z]+\:.+/i', $link)) { // usafe
          $alt = $newalt;
        } else {
          $link = '';
        }
        
        $this->neasden->resource_detected ($filebasename);
        
        $filename = $myconf['folder'] . $filebasename;
        $pathinfo = pathinfo ($filename);
        
        $width = $height = $ratio = 0;

        try {
          require_once @$this->neasden->config['library'] .'getid3/getid3.php';
          $info = new getid3 ();
          $info = $info->analyze ($filename);
          $width = $info['video']['resolution_x'];
          $height = $info['video']['resolution_y'];
          // require_once @$this->neasden->config['library'] .'mp4info/MP4Info.php';
          // $info = MP4Info::getInfo ($filename);
          // if ($info->hasVideo) {
          //   $width = $info->video->width;
          //   $height = $info->video->height;
          // }
        } catch (\Exception $e) {}

        if (substr ($filebasename, strrpos ($filebasename, '.') - 3, 3) == '@2x') {
          $width /= 2;
          $height /= 2;
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
          '<video src="'. $myconf['src-prefix'] . $filebasename .'" '.
          'width="'. $width .'" height="'. $height.'" '.
          'controls '.
          'alt="'. htmlspecialchars ($alt) .'" />'. "\n"
        );
  
        if (! $this->neasden->config['html.basic']) {
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

        $result .= $video_html;
        
      } elseif ($line['class'] == 'timed-media-section') {
        
        $ranges[] = $line['class-data'];

      } else {
        if (!$p) {
          $p = true;
          $result .= '<div class="e2-text-caption">' . $line['content'];
        } else {
          $result .= '<br />' . "\n" . $line['content'];
        }
      }
    }
  
    if ($p) $result .= '</div>'."\n";
  
    // code duplication with onlinevideo.php, audio.php :-(
    if (count ($ranges)) {
      $result .= '<div class="e2-media-sections">'."\r\n";
      $result .= '<table cellpadding="0" cellspacing="0" border="0">'."\r\n";
      foreach ($ranges as $range) {
        $item = [
          'to' => $range[1],
          'title' => $range[3],
        ];
        $result .= '<tr class="e2-media-control e2-media-sections-item" data-type="seek" '."\r\n";
        $result .= 'data-to="'. $item['to'] .'" '."\r\n";
        $result .= 'data-href="'. $myconf['src-prefix'] . $filebasename .'">'."\r\n";
        $result .= '<td style="width: 1px; white-space: nowrap"><span>'. $item['to'] .'</span></td>'."\r\n";
        $result .= '<td class="e2-media-sections-item-title"><span>'. $item['title'] .'</span></td>'."\r\n";
        $result .= '</tr>'."\r\n";
      }
      $result .= '</table>'."\r\n";
      $result .= '</div>'."\r\n";
    }

    $result .= '</div>'."\n";
    
    return $result;
    
  }
  
}

?>
