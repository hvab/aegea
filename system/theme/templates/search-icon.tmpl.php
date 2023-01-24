<?php if (!$content['blog']['virgin?'] and !count ($content['main-menu']['each'])) { ?>

<form
  class="e2-search-box-nano e2-enterable"
  action="<?= @$content['form-search']['form-action'] ?>"
  method="post"
  <?php if (array_key_exists ('form', $content) and $content['form'] !== 'form-comment') { ?>
  target="_blank"
  <?php } ?>
  accept-charset="utf-8"
>
  <label>
    <input class="js-search-query" type="search" inputmode="search" name="query" id="query" value="<?= @$content['form-search']['query'] ?>" placeholder="<?= _S ('gs--search')?>" required="required" />
    <span class="e2-search-icon">
      <span class="e2-search-icon-usual"><span class="e2-svgi"><?= _SVG ('loupe') ?></span></span>
      <span class="e2-search-icon-blank-window"><span class="e2-svgi"><?= _SVG ('loupe-blank-window') ?></span></span>
    </span>
  </label>
</form>

<?php } ?>