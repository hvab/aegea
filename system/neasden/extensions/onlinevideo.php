<?php

class NeasdenGroup_onlinevideo implements NeasdenGroup {

  function __construct ($neasden) {
    $this->neasden = $neasden;
  
    $neasden->define_line_class (
      'youtube',
      'https?\:\/\/(?:www\.)?(?:(?:youtube\.com\/watch\/?\?v\=)|(?:youtu\.be\/))(.{11})([&#?].*)?'
    );
    $neasden->define_line_class (
      'vimeo',
      'https?\:\/\/(?:www\.)?(?:(?:vimeo\.com\/))(\d+)'
    );

    $neasden->define_group ('onlinevideo', '(?:(-youtube-)|(-vimeo-))(-p-)*');

  }
  
  function render ($group, $myconf) {

    $p = false;

    $max_width = $myconf['max-width'];
    $ratio = $myconf['ratio'];

    $result = '<div class="'. $myconf['css-class'] .'">'."\n";
    foreach ($group as $line) {
    
      $id = $line['class-data'][1];
      $src = '';


      if ($line['class'] == 'youtube') {
        $src = 'https://www.youtube.com/embed/'. $id;
        $this->neasden->resource_detected ($src);
        // check files.php for www.youtube.com, this is important
      }

      if ($line['class'] == 'vimeo') {
        $src = 'https://player.vimeo.com/video/'. $id .''; //?title=0&amp;byline=0&amp;portrait=0
        $this->neasden->resource_detected ($src);
        // check files.php for player.vimeo.com, this is important
      }

      if ($line['class'] == 'youtube' or $line['class'] == 'vimeo') {

        if ($this->neasden->config['html.basic']) {

          $image_html = '<iframe src="'. $src .'" frameborder="0" allowfullscreen></iframe>';

        } else {

          // wrap into upyachka fix
          $image_html = (
            '<div style="width: '. $max_width .'px; max-width: 100%">'.
            '<div class="e2-text-picture-imgwrapper" style="'.
            'padding-bottom: '. round (100 / $ratio, 2).'%'.
            '">'.
            '<iframe width="100%" height="100%" style="position: absolute" '.
            'src="'. $src .'" frameborder="0" allowfullscreen>'.
            '</iframe>'.
            '</div>'.
            '</div>'
          );

        }

        $result .= $image_html;

        
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

    $result .= '</div>'."\n";
  
    return $result;
    
  }
  
}

?>