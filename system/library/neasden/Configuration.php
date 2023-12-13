<?php

namespace Neasden;

class Configuration {

  public $library = '';
  public $baseUrl = '';
  public $pathMedia = '';
  public $language = '';

  public $htmlOn = false;
  public $htmlElementsOpaque = false;
  public $htmlElementsIgnore = false;
  public $htmlElementsSacred = false;
  public $htmlBasic = false;

  public $htmlCodeOn = false;
  public $htmlCodeWrap = ['', ''];
  public $htmlCodeRequireLinks = false;

  public $htmlImgSrcPrefix = '';
  public $htmlImgDetect = false;

  public $groupsOn = false;
  public $groupsHeadingsChar = '';
  public $groupsHeadingsPlus = 0;
  public $groupsQuotesChar = '';
  public $groupsListsChars = [];
  public $groupsGenericCssClass = '';

  public $typographyOn = false;
  public $typographyQuotes = false;
  public $typographyMarkup = false;
  public $typographyAutoHref = false;
  public $typographyNoFollowHrefs = false;
  public $typographyUndecoratedLinksCssClass = false;
  public $typographyCleanup = [];

  public $additionalExtensionsFolder = null;

  public $extensions = [];

  function getExtensions () {

    $result = [];

    $host_dir = dirname ($_SERVER['PHP_SELF']); # '/meanwhile'
    $host_dir = trim ($host_dir, '/').'/'; # 'meanwhile/'
    if ($host_dir == '/') $host_dir = '';
    
    $dir = rtrim (dirname (__FILE__), '/'). '/';
    $dir = str_replace ($_SERVER['DOCUMENT_ROOT'] .'/'. $host_dir, '', $dir);

    $interpreters_folder = $dir .'Interpreters/';
    $renderers_folder = $dir .'Renderers/';

    foreach ($this->extensions as $k => $v) {

      if (is_string ($k)) {
        $extension = $k;
        $myconf = $v;
      } elseif (is_string ($v)) {
        $extension = $v;
        $myconf = [];
      } else {
        throw new \LogicException (
          'Wrong extension configuration: each item must have a string key or must be a string itself'
        );
      }

      if (!is_file ($interpreter_filename = $interpreters_folder . $extension .'Interpreter.php')) {
        throw new \LogicException (
          'Interpreter extension '. $extension .' not found'
        );
      }

      if (!is_file ($renderer_filename = $renderers_folder . $extension .'Renderer.php')) {
        throw new \LogicException (
          'Renderer extension '. $extension .' not found'
        );
      }

      $result[$extension] = [
        'interpreter-filename' => $interpreter_filename,
        'renderer-filename' => $renderer_filename,
        'configuration' => $myconf
      ];

    }
    
    return $result;

  }

}

class DefaultConfiguration extends Configuration {

  public $htmlOn = true;
  public $htmlElementsOpaque = 'p ul ol li pre';
  public $htmlElementsIgnore = 'div blockquote table tr td th thead tbody tfoot caption colgroup col';
  public $htmlElementsSacred = 'object embed iframe head link script style code textarea';
  public $htmlBasic = false;

  public $htmlCodeOn = true;
  public $htmlCodeWrap = ['<pre><code>', '</code></pre>'];
  public $htmlCodeRequireLinks = false;

  public $htmlImgSrcPrefix = '';
  public $htmlImgDetect = true;

  public $groupsOn = true;
  public $groupsHeadingsChar = '#';
  public $groupsHeadingsPlus = 0;
  public $groupsQuotesChar = '>';
  public $groupsListsChars = ['-', '*'];
  public $groupsGenericCssClass = 'txt-generic-object';

  public $extensions = [
    'HR',
    'Block',
    'List',
    'Table' => [
      'css-class' => 'txt-table',
    ],
    'MediaTimecodes',
    'Picture' => [
      'src-prefix' => 'pictures/',
      'folder' => 'pictures/',
      'css-class' => 'txt-picture', // see also var csscPrefix in scaleimage.js
      'max-width' => '768',
      'scaled-img-folder' => 'pictures/scaled/',
      //'scaled-img-provider' => '@scale-image:',
      'scaled-img-extension' => 'scaled.jpg',
      'scaled-img-link-to-original' => true,
      'scaled-img-link-to-original-class' => 'link-to-big-picture',
    ],
    'Fotorama' => [
      'src-prefix' => 'pictures/',
      'folder' => 'pictures/',
      'css-class' => 'txt-picture', // see also var csscPrefix in scaleimage.js
      'max-width' => '768',
    ],
    'Video',
    'OnlineVideo' => [
      'css-class' => 'txt-video',
      'max-width' => '768',
      'ratio' => 16/9,
    ],
    // 'Youtube' => [
    //   'css-class' => 'txt-video',
    //   'width' => 768,
    //   'height' => 480,
    // ],
    // 'Vimeo' => [
    //   'css-class' => 'txt-video',
    //   'width' => 768,
    //   'height' => 480,
    // ],
    'Audio' => [
      'src-prefix' => 'audio/',
      'folder' => 'audio/',
    ],
  ];

  public $typographyOn = true;
  public $typographyQuotes = true;
  public $typographyMarkup = true;
  public $typographyAutoHref = true;
  public $typographyNoFollowHrefs = false;
  public $typographyUndecoratedLinksCssClass = false;
  public $typographyCleanup = [
    '&nbsp;' => ' ',
    '&laquo;' => '«',
    '&raquo;' => '»',
    '&bdquo;' => '„',
    '&ldquo;' => '“',
    '&rdquo;' => '”',
  ];

  public $additionalExtensionsFolder = null;

}


?>