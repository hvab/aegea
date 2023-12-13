<?php

namespace Neasden;

class OnlineVideoInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;
  
    $this->neasden -> defineLineClass (
      'youtube',
      'https?\:\/\/(?:www\.)?'.
      '(?:(?:youtube\.com\/watch\/?\?v\=)|(?:youtu\.be\/))'.
      '([A-Za-z0-9_-]{11})([&#?].*)?'
    );
    $this->neasden -> defineLineClass (
      'vimeo',
      'https?\:\/\/(?:www\.)?(?:(?:vimeo\.com\/))(\d+)'
    );
    $this->neasden -> requireLineClass ('media-timecode');

    $this->neasden -> defineGroup ('OnlineVideo', '(?:(-youtube-)|(-vimeo-))(?:(-p-)*|(-media-timecode-)*)');

  }
  
  public function interpret ($group, $myconf) {

    $interpretation = [];
    $caption_lines_content = [];

    foreach ($group as $line) {

      if ($line['class'] == 'youtube' or $line['class'] == 'vimeo') {

        $source_id = $line['class-data'][0];
        $id = $line['class-data'][1];

        if ($line['class'] == 'youtube') {
          // enablejsapi=1 is required to be able to manipulate this video through YouTube Iframe API:
          // https://developers.google.com/youtube/iframe_api_reference#Example_Video_Player_Constructors
          $src = 'https://www.youtube.com/embed/'. $id .'';
          $this->neasden -> resourceDetected ($src);
          $src .= '?enablejsapi=1';
          // check resources.php for www.youtube.com, this is important
        }

        if ($line['class'] == 'vimeo') {
          $src = 'https://player.vimeo.com/video/'. $id .''; //?title=0&amp;byline=0&amp;portrait=0
          $this->neasden -> resourceDetected ($src);
          // check resources.php for player.vimeo.com, this is important
        }

        $interpretation = [
          'type' => 'online-video',
          'service' => $line['class'],
          'source' => $source_id,
          'id' => $id,
        ];
      }

      if ($line['class'] === 'p') {
        $caption_lines_content[] = $line['content'];
      }
      
      if ($line['class'] === 'media-timecode') {  
        $this->neasden -> requireLink ('jquery/jquery.js');
        $this->neasden -> requireLink ('media-seek/media-seek.js');

        $interpretation['timecodes'][] = [
          'timecode' => $line['class-data'][1],
          'title' => $line['class-data'][3],
        ];
      }

    }

    if (count ($caption_lines_content)) {
      $interpretation['caption'] = implode ("\n", $caption_lines_content);
    }

    return $interpretation;

  }
  
}

?>
