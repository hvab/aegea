<div class="e2-heading">
  
<span class="e2-search">

<form
  id="e2-search"
  class="e2-enterable"
  action="<?= @$content['search']['form-action'] ?>"
  method="post"
  accept-charset="utf-8"
>
  <label class="e2-search-input">
    <input class="e2-search-input-input text" type="text" name="query" id="query"
      value="<?= @$content['search']['query'] ?>" />

      <div class="e2-search-icon"><?= _SVG ('loupe') ?></div>
      <div class="e2-search-icon-placeholder"></div>

  </label>
  <?php if (count ($content['tags']['each']) > 0) { ?>
  <?php if (array_key_exists ('tags', $content['hrefs']) and $content['class'] != 'found') { ?>
  <span class="e2-search-tags">
    <?php if (_AT ($content['hrefs']['tags'])) { ?>
    <span class="e2-svgi"><?= _SVG ('tags') ?></span>
    <?php } else { ?>
    <a class="nu" href="<?= $content['hrefs']['tags'] ?>" title="<?= _S ('gs--tags') ?>"><span class="e2-svgi"><?= _SVG ('tags') ?></span></a>
    <?php } ?>
  </span>
  <?php } ?>
  <?php } ?>
</form>

</span>

<?php if (array_key_exists ('search-related-tag', $content)) { ?> 
<div class="e2-heading-see-also">
  <?= _S ('gs--see-also-tag') ?> <a href="<?=$content['search-related-tag']['href']?>" class="e2-tag"><?=$content['search-related-tag']['name']?></a>
</div>
<?php } ?>

</div>
