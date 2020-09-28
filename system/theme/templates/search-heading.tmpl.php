<span class="e2-search">

<form
  id="e2-search"
  class="e2-enterable"
  action="<?= @$content['form-search']['form-action'] ?>"
  method="post"
  accept-charset="utf-8"
>
  <label class="e2-search-input">
    <input class="e2-search-input-input text" type="text" name="query" id="query"
      value="<?= @$content['form-search']['query'] ?>" />

      <div class="e2-search-icon"><?= _SVG ('loupe') ?></div>
      <div class="e2-search-icon-placeholder"></div>

  </label>
</form>

</span>

<?php if (array_key_exists ('search-related-tags', $content)) { ?> 
<div class="e2-heading-see-also">
<?php
$tags = array ();
foreach ($content['search-related-tags'] as $tag) {
  if ($tag['current?']) {
    $tags[] = '<mark class="e2-tag">'. $tag['name'] .'</mark>';
  } else {
    $tags[] = '<a href="'. $tag['href'] .'" class="e2-tag">'. $tag['name'] .'</a>';
  }
}
?>
  <span class="e2-heading-see-also-title"><?= _S ('gs--see-also') ?>:</span><?= implode (' &nbsp; ', $tags) ?>
</div>
<?php } ?>