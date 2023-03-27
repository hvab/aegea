<form
  class="e2-search-box e2-enterable"
  action="<?= @$content['form-search']['form-action'] ?>"
  method="post"
  accept-charset="utf-8"
>
<label>
  <span class="e2-search-icon"><span class="e2-svgi"><?= _SVG ('loupe') ?></span></span>
  <input class="js-search-query" type="search" inputmode="search" name="query" id="query" value="<?= @$content['form-search']['query'] ?>" placeholder="<?= _S ('gs--search')?>" required="required" />
</label>
</form>

<?php if (array_key_exists ('search-related-tags', $content)) { ?>

<div class="e2-band e2-band-meta-size e2-heading-meta">
<div class="e2-band-scrollable js-band-scrollable">
  <div class="js-band-scrollable-inner">
  <nav>
    <?php $content['_']['_tags_line']['_prepend'] = _S ('gs--see-also') .':'; ?>
    <?php $content['_']['_tags_line']['_tags'] = $content['search-related-tags']; ?>
    <?php _T ('tags-line') ?>
  </nav>
  </div>
</div>
</div>

<?php } ?>