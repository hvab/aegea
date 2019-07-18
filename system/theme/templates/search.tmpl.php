<form
  id="e2-search"
  class="search-field search-field-right-anchored e2-enterable"
  action="<?= @$content['search']['form-action'] ?>"
  method="post"
  accept-charset="utf-8"
>
  <label class="search-field__label">
    <input class="search-field__input" type="text" name="query" id="query" value="<?= @$content['search']['query'] ?>" />
    
    <div class="search-field__zoom-icon"><?= _SVG ('loupe') ?></div>
    
    <?php if (count ($content['tags']['each']) > 0 && array_key_exists ('tags', $content['hrefs']) && ! _AT ($content['hrefs']['tags'])) { ?>
      <a class="nu search-field__tags-icon" href="<?= $content['hrefs']['tags'] ?>" title="<?= _S ('gs--tags') ?>">
        <span class="e2-svgi"><?= _SVG ('tags') ?></span>
      </a>
    <?php } ?>
  </label>

</form>
