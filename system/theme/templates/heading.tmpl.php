<?php if ($content['class'] == 'found') { ?>

  <?php _T ('search-heading') ?>
  
<?php } elseif (array_key_exists ('heading', $content)) { ?>
  
  <div class="e2-heading">

    <span class="admin-links admin-links-floating <?php if ($content['class'] != 'settings'): ?>admin-links-sticky<?php endif ?>">

      <?php if (array_key_exists ('related-edit-href', $content)): ?>
      <span class="admin-icon"><a href="<?= $content['related-edit-href'] ?>" class="nu e2-edit-link e2-admin-link"><span class="e2-svgi"><?= _SVG ('edit') ?></span></a></span>
      <?php endif ?>

      <?php if (array_key_exists ('related-delete-href', $content)) { ?>
      <span class="admin-icon"><a href="<?= @$content['related-delete-href'] ?>" class="nu e2-admin-link"><span class="e2-svgi"><?= _SVG ('trash') ?></span></a></span>
      <?php } ?>

      <?php if ($content['class'] == 'settings'): ?>
      <?php if (array_key_exists ('sign-out-href', $content['admin'])): ?>
      <span class="admin-icon"><a href="<?= $content['admin']['sign-out-href'] ?>" class="nu e2-admin-link"><span class="e2-svgi"><?= _SVG ('exit') ?></span></a></span>
      <?php endif ?>
      <?php endif ?>

    </span>

    <?php if (array_key_exists ('superheading', $content)): ?>
    <div class="e2-heading-super"><?= $content['superheading'] ?></div>
    <?php endif ?>
    
    <h2><?= $content['heading'] ?></h2>
  
    <?php if (array_key_exists ('description', $content['tag'])): ?>
    <div class="e2-heading-description e2-text">
      <?= $content['tag']['description'] ?>
    </div>
    <?php endif ?>

    <?php _T_FOR ('year-months') ?>
    <?php _T_FOR ('month-days') ?>

  </div>

<?php } ?>