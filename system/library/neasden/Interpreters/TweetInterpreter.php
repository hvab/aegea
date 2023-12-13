<?php

namespace Neasden;

class TweetInterpreter implements InterpreterExtension {

  private $neasden = null;

  function __construct ($neasden) {

    $this->neasden = $neasden;
  
    $this->neasden -> defineLineClass (
      'tweet',
      'https?\:\/\/(?:www\.)?(?:twitter\.com\/(#!\/)?(\w+)\/status\/)(\d+)([&#?].*)?'
    );

    $this->neasden -> defineGroup ('Tweet', '(-tweet-)');
  
  }

  public function interpret ($group, $myconf) {

    $this->neasden -> requireLink ('https://platform.twitter.com/widgets.js');
    $this->neasden -> requireLink ('embedded-tweet/embedded-tweet.js');
    
    return $group;
    
  }
  
}

?>