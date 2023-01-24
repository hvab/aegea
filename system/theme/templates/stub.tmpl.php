<div class="common">
  <div class="flag"></div>

  <div class="content">

    <div class="e2-heading">
      <div><div class="e2-logo-svg"><?= _SVG ('aegea') ?></div></div>
      <h2>
        <?php if (array_key_exists ('heading', $content)) { ?>
        <?= $content['heading'] ?>
        <?php } ?>
      </h2>
    </div>

    <div class="e2-heading-description e2-text">
      <?= $content['stub'] ?>
    </div>

    <?php _T ('message') ?>

    <?php if ($content['stub-button-href']) { ?>
    <a class="e2-button e2-submit-button" href="<?= $content['stub-button-href'] ?>">
      <?= $content['stub-button-text'] ?>
    </a>
    <?php } ?>

    <!-- <?= $content['stub-kind'] ?> -->

  </div>
</div>