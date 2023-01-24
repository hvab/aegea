<?php $prepend = $content['_']['_tags_line']['_prepend']; ?>
<?php $tags = $content['_']['_tags_line']['_tags']; ?>
<?php unset ($content['_']['_tags_line']); ?>

<?php

$tags_html = [];
foreach ($tags as $tag) {

  $tag_html = $tag['name'];
  if (!$tag['visible?']) {
    $tag_html = '<span class="e2-svgi e2-svgi-lock-nano">'. _SVG ('lock-nano') .'</span> '. $tag_html;
  }
  if ($tag['current?']) {
    $tag_html = '<mark><span class="e2-tag">'. $tag_html .'</span></mark>';
  } else {
    $tag_html = (
      '<a href="'. $tag['href'] .'" '.
      'class="e2-tag">'.
      $tag_html .
      '</a>'
    );
  }
  $tags_html[] = $tag_html;
}

$tags_html = implode (' &nbsp; ', $tags_html);

if ((string) $tags_html !== '') {
  $tags_html = $prepend . $tags_html;
}

echo $tags_html;

?>
