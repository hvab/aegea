<?php

namespace Neasden;

class TweetRenderer implements RendererExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;
  
  }

  public function render ($interpretation, $myconf) {

    $result = '';

    if (! $this->neasden -> getConfiguration () -> htmlBasic) {
      $result = '<div class="'. $myconf['css-class'] .'">'."\n";
    }

    foreach ($interpretation as $line) {
    
      if ($line['class'] === 'tweet') {
        
        $who = $line['class-data'][1];
        $id = $line['class-data'][2];

        // make a regular link to tweet.
        // we need to isolate it, otherwise typography.autohref
        // will wrap the link into another a href:       

        // $link_to_tweet = $this->neasden -> isolate (
        //   '<p><a href="'. $line['class-data'][0] .'">'.
        //   $line['class-data'][0].
        //   '</a></p>'
        // );

        $link_text = parse_url ($line['class-data'][0]);
        $link_text = str_replace ($link_text['scheme']. '://', '', $line['class-data'][0]);

        $link_to_tweet = (
          '<p><a href="'. $line['class-data'][0] .'">'.
          $link_text.
          '</a></p>'
        );

        // transform into live tweet with a script later

        if (! $this->neasden -> getConfiguration () -> htmlBasic) {
          
          $link_to_tweet = (
            '<div class="e2-embedded-tweet" data-tweet-id="'. $id .'">'.
            $link_to_tweet .
            '</div>'
          );

        }

        $result .= $link_to_tweet;
        
      } 
      
    }
  
    if (! $this->neasden -> getConfiguration () -> htmlBasic) {
      $result .= '</div>'."\n";
    }
  
    return $result;
    
  }
  
}

?>