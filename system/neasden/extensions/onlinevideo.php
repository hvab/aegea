<?php

class NeasdenGroup_onlinevideo implements NeasdenGroup {

  function __construct ($neasden) {
    $this->neasden = $neasden;
  
    $neasden->require_line_class ('timed-media-section');
    $neasden->define_line_class (
      'youtube',
      'https?\:\/\/(?:www\.)?(?:(?:youtube\.com\/watch\/?\?v\=)|(?:youtu\.be\/))(.{11})([&#?].*)?'
    );
    $neasden->define_line_class (
      'vimeo',
      'https?\:\/\/(?:www\.)?(?:(?:vimeo\.com\/))(\d+)'
    );

    $neasden->define_group ('onlinevideo', '(?:(-youtube-)|(-vimeo-))(?:(-p-)*|(-timed-media-section-)*)');

  }
  
  function render ($group, $myconf) {
    $this->neasden->require_link (@$this->neasden->config['library']. 'jquery/jquery.js');
    $this->neasden->require_link (@$this->neasden->config['library']. 'media-seek/media-seek.js');

    $p = false;

    $max_width = $myconf['max-width'];
    $ratio = $myconf['ratio'];
    $ranges = [];
    
    $result = '<div class="'. $myconf['css-class'] .'">'."\n";
    foreach ($group as $line) {
      $src = '';

      if ($line['class'] == 'youtube' or $line['class'] == 'vimeo') {

        $resname = $line['class-data'][0];
        $id = $line['class-data'][1];
        
        if ($line['class'] == 'youtube') {
          // enablejsapi=1 is required to be able to manipulate this video through YouTube Iframe API:
          // https://developers.google.com/youtube/iframe_api_reference#Example_Video_Player_Constructors
          $src = 'https://www.youtube.com/embed/'. $id .'';
          $this->neasden->resource_detected ($src);
          $src .= '?enablejsapi=1';
          // check resources.php for www.youtube.com, this is important
        }

        if ($line['class'] == 'vimeo') {
          $src = 'https://player.vimeo.com/video/'. $id .''; //?title=0&amp;byline=0&amp;portrait=0
          $this->neasden->resource_detected ($src);
          // check resources.php for player.vimeo.com, this is important
        }

        if ($this->neasden->config['html.basic']) {

          // allow="autoplay" here allows to play videos using JS when user clicks on a timestamp
          $image_html = '<iframe src="'. $src .'" allow="autoplay" frameborder="0" allowfullscreen></iframe>';

        } else {

          // wrap into upyachka fix
          $image_html = (
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

        $result .= $image_html;

        
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

    // code duplication with video.php, audio.php :-(
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
        $result .= 'data-href="'. $resname .'">'."\r\n";
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
