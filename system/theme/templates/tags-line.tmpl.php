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
    $tag_html = '<span class="band-item-inner"><mark><span class="e2-tag">'. $tag_html .'</span></mark></span>';
  } else {
    $tag_html = (
      '<a href="'. $tag['href'] .'" '.
      'class="e2-tag band-item-inner">'.
      $tag_html .
      '</a>'
    );
  }
  $tag_html = '<div class="band-item">'. $tag_html .'</div>';

  $tags_html[] = $tag_html;
}

// $tags_html = implode (' &nbsp; ', $tags_html);
$tags_html = implode ('', $tags_html);

if ((string) $prepend !== '' and (string) $tags_html !== '') {
  $tags_html = (
    '<div class="band-item">'.
    '<div class="band-item-inner">'.
    $prepend .
    '</div>'.
    '</div>'
  ) . $tags_html;
}

echo $tags_html;

?>
