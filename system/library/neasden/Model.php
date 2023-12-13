<?php

namespace Neasden;

class Model {

  private $links;
  private $resources;
  private $flow;

  private $links_debug_info;
  private $resources_debug_info;
  private $flow_debug_info;

  public $debug = false;

  function __construct ($array = null) {

    $this->links = [];
    $this->resources = [];
    $this->flow = [];
    $this->flow_debug_info = [];

    if (is_array ($array)) {
      if (array_key_exists ('meta', $array) and is_array ($array['meta'])) {
        $meta = $array['meta'];
        if (array_key_exists ('links', $meta) and is_array ($meta['links'])) {
          $this->links = $meta['links'];
        }
        if (array_key_exists ('resources', $meta) and is_array ($meta['resources'])) {
          $this->resources = $meta['resources'];
        }
      }
      if (array_key_exists ('elements', $array) and is_array ($array['elements'])) {
        $this->flow = $array['elements'];
      }
    }

  }

  function addResource ($resource, $debug_info = []) {
    if (!in_array ($resource, $this->resources)) {
      $this->resources[] = $resource;
      if ($this->debug) {
        $this->resources_debug_info[] = $debug_info;
      }
    }
  }

  function addLink ($link, $debug_info = []) {
    if (!in_array ($link, $this->links)) {
      $this->links[] = $link;
      if ($this->debug) {
        $this->links_debug_info[] = $debug_info;
      }
    }
  }

  function addElement ($band, $debug_info = []) {

    $this->flow[] = $band;
    if ($this->debug) {
      $this->flow_debug_info[] = $debug_info;
    }

  }

  function addOpaqueElement ($content, $debug_info = []) {

    $this -> addElement ([
      '_o',
      $content,
    ], $debug_info);

  }

  function addRawElement ($content, $debug_info = []) {

    $this -> addElement (['_r', $content,], $debug_info);

  }

  function addCodeElement ($content, $language, $debug_info = []) {
    
    $class = '_c';
    if ((string) @$language !== '') $class .= '.'. $language;

    $this -> addElement ([$class, $content], $debug_info);

  }

  function addGroupElement ($class, $lines, $debug_info = []) {

    $lines_content = [];
    foreach ($lines as $line) {
      $lines_content[] = $line['content'];
    }

    if ($class === 'p' and count ($lines_content)) {

      $this -> addElement (implode ("\n", $lines_content), $debug_info);

    } elseif ($class === 'h') {

      $this -> addElement ([
        'h' . $line['-heading-level'],
        implode ("\n", $lines_content)
      ], $debug_info);

    } else {

      $this -> addElement ([
        $class, $lines
      ], $debug_info);
      
    }

  }

  function getResources () {
    return $this->resources;
  }

  function getLinks () {
    return $this->links;
  }

  function getFlow () {
    return $this->flow;
  }

  function toArray () {

    return [
      'version' => '1',
      'meta' => [
        'resources' => $this->resources,
        'links' => $this->links,
      ],
      'flow' => $this->flow,
    ];

  }

  static function expandFlowElement ($element) {

    if (is_string ($element)) {
      return [
        'kind' => 'group',
        'class' => 'p',
        'subclass' => '',
        'lines' => explode ("\n", $element),
      ];
    }

    list ($element_class, $element_band_lines) = $element;

    if ($element_class[0] === 'h') {
      $element_subclass = (int) substr ($element_class, 1);
      $element_class = 'h';
      $element_band_lines = explode ("\n", $element_band_lines);
    } else {
      $element_subclass = '';
      if (strstr ($element_class, '.')) {
        list ($element_class, $element_subclass) = explode ('.', $element_class);
      }
    }

    if ($element_class[0] !== '_') {
      return [
        'kind' => 'group',
        'class' => $element_class,
        'subclass' => (string) @$element_subclass,
        'lines' => $element_band_lines
      ];
    }

    return [
      'kind' => 'non-group',
      'class' => $element_class,
      'subclass' => (string) @$element_subclass,
      'content' => $element_band_lines
    ];

  }

}

?>