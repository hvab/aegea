<?php

global $settings, $_lang, $_config;

return array (

  '__overload' => 'user/neasden/',
  
  '__profiles' => array (
    'full-rss' => array (
      'html.on' => true,
      'html.basic' => true,
      'groups.on' => true,
      'typography.markup' => true,
      'typography.autohref' => true,
      'typography.nofollowhrefs' => $_config['nofollow_hrefs_in_posts'],
      'banned-groups' => array (),
    ),
    'full' => array (
      'html.on' => true,
      'groups.on' => true,
      'typography.markup' => true,
      'typography.autohref' => true,
      'typography.nofollowhrefs' => $_config['nofollow_hrefs_in_posts'],
      'banned-groups' => array (),
    ),
    'simple-rss' => array (
      'html.on' => false,
      'html.basic' => true,
      'groups.on' => true,
      'typography.markup' => true,
      'typography.autohref' => true,
      'typography.nofollowhrefs' => $_config['nofollow_hrefs_in_comments'],
      'banned-groups' => array (
        'picture', 'video', 'fotorama', 'audio', 'youtube', 'vimeo'
      ),
    ),
    'simple' => array (
      'html.on' => false,
      'groups.on' => true,
      'typography.markup' => true,
      'typography.autohref' => true,
      'typography.nofollowhrefs' => $_config['nofollow_hrefs_in_comments'],
      'banned-groups' => array (
        'picture', 'video', 'fotorama', 'audio', 'youtube', 'vimeo'
      ),
    ),
    'kavychki' => array (
      'html.on' => true,
      'html.code.on' => false,
      'groups.on' => false,
      'typography.markup' => false,
      'typography.autohref' => false,
    ),
 ),
    
  'library' => SYSTEM_DIR . LIBRARY_DIRNAME,
  
  'language' => $_lang,
  
  'html.on' => true,
  'html.elements.opaque' => 'p ul ol li pre',
  'html.elements.ignore' => 'div blockquote table tr td th thead tbody tfoot caption colgroup col',
  'html.elements.sacred' => 'object embed iframe head link script style code textarea',
  'html.basic' => false,

  'html.code.on' => true,
  'html.code.wrap' => array ('<pre class="e2-text-code"><code class="%s">', '</code></pre>'),  
  'html.code.highlightjs' => true,

  'html.img.prefix' => AeEnv::$base_url . PICTURES_DIRNAME,
  'html.img.detect' => true,

  'groups.on' => true,
  'groups.headings.char'  => '#',
  'groups.headings.plus'  => 1,
  'groups.quotes.char' => '>',
  'groups.lists.chars' => array ('-', '*'),
  'groups.generic-css-class' => 'e2-text-generic-object',
  'groups.classes' => array (
    'picture' => array (
      'src-prefix' => AeEnv::$base_url . PICTURES_DIRNAME,
      'folder' => $_config['path_media'] . PICTURES_DIRNAME,
      'css-class' => 'e2-text-picture', 
      'max-width' => $_config['max_image_width'],
    ),
    'video' => array (
      'src-prefix' => AeEnv::$base_url . VIDEO_DIRNAME,
      'folder' => $_config['path_media'] . VIDEO_DIRNAME,
      'css-class' => 'e2-text-video', 
      'max-width' => $_config['max_image_width'],
    ),
    'fotorama' => array (
      'src-prefix' => AeEnv::$base_url . PICTURES_DIRNAME,
      'folder' => $_config['path_media'] . PICTURES_DIRNAME,
      'css-class' => 'e2-text-picture',
      'max-width' => $_config['max_image_width'],
    ),
    'table' => array (
      'css-class' => 'e2-text-table',
    ),
    'onlinevideo' => array (
      'css-class' => 'e2-text-video',
      'max-width' => $_config['max_image_width'],
      'ratio' => 16/9,
    ),
    'audio' => array (
      'css-class' => 'e2-text-audio',
      'src-prefix' => AeEnv::$base_url . AUDIO_DIRNAME,
      'folder' => $_config['path_media'] . AUDIO_DIRNAME,
    ),
    'tweet' => array (
      'css-class' => 'e2-text-generic-object',
    ),
  ),
  
  'typography.on' => true,
  'typography.quotes' => true,
  'typography.markup' => true,
  'typography.autohref' => true,
  'typography.cleanup' => array (
    '&nbsp;' => ' ',
    '&laquo;' => '«',
    '&raquo;' => '»',
    '&bdquo;' => '„',
    '&ldquo;' => '“',
    '&rdquo;' => '”',
  ),

); ?>