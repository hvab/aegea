<?php if (count ($content['main-menu']['each'])) { ?>

<div class="header-menu">
<div class="e2-band e2-band-full-size">
<div class="e2-band-scrollable js-band-scrollable">
  <div class="js-band-scrollable-inner">

    <?php if ($content['main-menu']['reorderable?']) { ?>
    <nav class="e2-js-menu-reorderable"
      data-action-save-order="<?= $content['main-menu']['save-order-action'] ?>"
    >
    <?php } else { ?>
    <nav>
    <?php } ?>

    <?php

      foreach ($content['main-menu']['each'] as $i => $tag) {

        // this filters out disabled menu items:
        if (!$tag['visible?']) continue;

        $item_icon_and_text = [];

        if ($tag['svg-id']) {
          $item_icon_and_text[] = (
            '<span class="band-item__icon e2-svgi">'.
            _SVG ($tag['svg-id']) .
            '</span>'
          );
        }

        if ($tag['title']) {
          $item_icon_and_text[] = $tag['title'];
        }

        $item_html = implode (' ', $item_icon_and_text);

        // wrap into link or span
        if ($tag['current?']) {
          $item_html = '<span class="band-item-inner">'. $item_html .'</span>';
        } else {
          $item_html = (
            '<a class="band-item-inner" href="'. $tag['href'] .'">'. $item_html .'</a>'
          );
        }

        $div_class = 'band-item';
        $div_attrs = '';
        
        if ($tag['parent?']) {
          $div_class .= ' band-item-parent';
        }
        
        if ($tag['current?']) {
          $div_class .= ' band-item-current';
        }

        if ($content['main-menu']['reorderable?']) {
          $div_class .= ' e2-js-menu-reorderable-item';
          $div_attrs .= ' data-id="'. $tag['sort-id'] .'"';
        }

        $item_html = (
          '<div class="'. $div_class .'"'. $div_attrs .'>'.
          $item_html .
          '</div>'
        );

        echo $item_html;

      }

    ?>

    </nav>
    
    <?php if (@$content['blog']['show-follow-button?']) { ?>
    <div class="band-right-section">
      <a class="band-follow-button e2-follow-button" href="<?= @$content['blog']['rss-href'] ?>">
        <span><?= _S ('gs--follow-this-blog') ?></span>
      </a>
    </div>
    <?php } ?>

  </div>
</div>

<?php if ($content['class'] != 'found') { ?>
<div class="e2-band-sticky">
  <div class="band-item">
    <div class="band-item-inner band-item-clickable">
      <form
        class="e2-search-box-banded e2-enterable"
        action="<?= @$content['form-search']['form-action'] ?>"
        method="post"
        <?php if (array_key_exists ('form', $content) and $content['form'] !== 'form-comment') { ?>
        target="_blank"
        <?php } ?>
        accept-charset="utf-8"
      >
        <label>
          <input class="js-search-query" type="search" inputmode="search" name="query" id="band-query" value="<?= @$content['form-search']['query'] ?>" placeholder="<?= _S ('gs--search')?>" required="required" />
          <span class="e2-search-icon">
            <span class="e2-search-icon-usual">
              <span class="band-item__icon e2-svgi"><?= _SVG ('loupe') ?></span>
            </span>
            <span class="e2-search-icon-blank-window">
              <span class="band-item__icon e2-svgi"><?= _SVG ('loupe-blank-window') ?></span>
            </span>
          </span>
        </label>
      </form>
    </div>
  </div>
</div>
<?php } ?>

</div>
</div>

<?php } ?>