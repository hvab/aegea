<?php if ($content['class'] == 'found') { ?>

  <div class="e2-heading">
    <?php _T ('search-heading') ?>
  </div>
  
<?php } elseif (!empty ($content['heading'])) { ?>
  
  <div class="e2-heading">

    <span class="admin-links admin-links-floating <?php if ($content['class'] != 'settings'): ?>admin-links-sticky<?php endif ?>">

      <?php if (array_key_exists ('tag', $content)): ?>
      <?php if (array_key_exists ('pinned-toggle-action', $content['tag'])): ?>
      <span class="admin-icon"><form action="<?= $content['tag']['pinned-toggle-action'] ?>" method="post" class="nu"><input type="hidden" name="token" value="<?= $content['sign-in']['token'] ?>" /><button type="submit" href="<?= $content['tag']['pinned-toggle-action'] ?>" class="e2-admin-link nu e2-admin-item <?= ($content['tag']['pinned?']? 'e2-admin-item_on' : '') ?>" data-e2-js-action="toggle-pinned" data-e2-js-action-token="<?= $content['sign-in']['token'] ?>"><span class="e2-svgi"><span class="e2-toggle-state-off"><?= _SVG ('pinned-off') ?></span><span class="e2-toggle-state-on"><?= _SVG ('pinned-on') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></button></form></span>
      <?php endif ?>
      <?php endif ?>

      <?php if (array_key_exists ('related-edit-href', $content)): ?>
      <span class="admin-icon"><a href="<?= $content['related-edit-href'] ?>" class="nu e2-edit-link e2-admin-link"><span class="e2-svgi"><?= _SVG ('edit') ?></span></a></span>
      <?php endif ?>

      <?php if (array_key_exists ('related-delete-href', $content)) { ?>
      <span class="admin-icon"><a href="<?= @$content['related-delete-href'] ?>" class="nu e2-admin-link"><span class="e2-svgi"><?= _SVG ('trash') ?></span></a></span>
      <?php } ?>

      <?php if ($content['class'] == 'settings'): ?>
      <?php if (array_key_exists ('sign-out-href', $content['admin'])): ?>

      <span class="admin-icon">
        <div class="e2-popup-menu" style="position: relative; top: -8px; left: -12px; width: 16px; height: 16px; display: inline-block;">
          <button type="button" class="e2-popup-menu-button">
            <span class="e2-popup-menu-button-icon"><span class="e2-svgi"><?= _SVG ('chevron-down') ?></span></span>
            <span class="e2-popup-menu-button-text"><?= _S ('ab--menu-actions') ?></span>
          </button>

          <div class="e2-popup-menu-widget">

            <?php if (array_key_exists ('password-href', $content['admin'])) { ?>
              <a href="<?= $content['admin']['password-href'] ?>" class="nu e2-popup-menu-widget-item">
                <span class="e2-popup-menu-widget-item-text"><?= _S ('gs--password') ?></span>
              </a> 
            <?php } ?>

            <?php if (array_key_exists ('sessions-href', $content['admin'])) { ?>
              <a href="<?= $content['admin']['sessions-href'] ?>" class="nu e2-popup-menu-widget-item">
                <span class="e2-popup-menu-widget-item-text"><?= _S ('pt--sessions') ?></span>
              </a> 
            <?php } ?>

            <?php if (array_key_exists ('database-href', $content['admin'])) { ?>
              <a href="<?= $content['admin']['database-href'] ?>" class="nu e2-popup-menu-widget-item">
                <span class="e2-popup-menu-widget-item-text"><?= _S ('gs--db-connection') ?></span>
              </a> 
            <?php } ?>

            <?php if (array_key_exists ('get-backup-href', $content['admin'])) { ?>
              <hr class="e2-popup-menu-widget-separator">

              <a href="<?= $content['admin']['get-backup-href'] ?>" class="nu e2-popup-menu-widget-item">
                <span class="e2-popup-menu-widget-item-text"><?= _S ('gs--get-backup') ?></span>
              </a> 
            <?php } ?>

            <hr class="e2-popup-menu-widget-separator">

            <a href="<?= $content['admin']['sign-out-href'] ?>" class="nu e2-popup-menu-widget-item">
              <span class="e2-popup-menu-widget-item-icon">
                <span class="e2-svgi"><?= _SVG ('exit') ?></span>
              </span>
              <span class="e2-popup-menu-widget-item-text"><?= _S ('fb--sign-out') ?></span>
            </a> 

          </div>

        </div>
      </span>

      <?php endif ?>
      <?php endif ?>

    </span>

    <?php if (array_key_exists ('tag', $content)) { ?>
    <?php if (array_key_exists ('visible?', $content['tag'])) { ?>
    <?php if (!$content['tag']['visible?']) { ?> <div class="e2-nonpublic-label"><span class="e2-svgi e2-svgi-lock-nano"><?= _SVG ('lock-nano') ?> </span> <?= _S ('gs--hidden') ?></div><?php } ?>
    <?php } ?>
    <?php } ?>
    <h2><?= $content['heading'] ?></h2>

    <?php _T_FOR ('calendar') ?>

    <?php if (array_key_exists ('tag', $content) and $content['pages']['this'] == 1) { ?>
    
      <?php if (array_key_exists ('popular', $content['tag'])) { ?>
      <?php if (array_key_exists ('each', $content['tag']['popular'])) { ?> 

      <?php $content['_']['_notes_gallery'] = $content['tag']['popular']; ?>

      <section class="e2-heading-gallery">
        <div class="e2-section-heading"><?=$content['tag']['popular']['title']?></div>
        <?php _T ('notes-gallery') ?>
      </section>

      <?php } ?>
      <?php } ?>

      <!-- <div class="e2-note-meta">
      <?= $content['tag']['notes-count-text'] ?>: <a href="">*с первой</a> · <a href="">с последней</a>
      </div> -->

      <?php if (array_key_exists ('related', $content['tag']) and count ($content['tag']['related'])) { ?>
      
      <div class="e2-band e2-band-meta-size e2-heading-meta">
      <div class="e2-band-scrollable js-band-scrollable">
        <div class="js-band-scrollable-inner">
        <nav>

        <div class="band-item">
          <div class="band-item-inner">
            <?= $content['tag']['notes-count-text'] ?>
          </div>
        </div>
        
        <?php $content['_']['_tags_line']['_prepend'] = _S ('gs--see-also') .':'; ?>
        <?php $content['_']['_tags_line']['_tags'] = $content['tag']['related']; ?>
        <?php _T ('tags-line') ?>

        </nav>
        </div>
      </div>
      </div>

      <?php } else {?>

      <div class="e2-heading-meta">
        <?= $content['tag']['notes-count-text'] ?>
      </div>

      <?php } ?>

      <?php if ((string) $content['tag']['description'] !== ''): ?>
      <div class="e2-heading-description e2-text">
        <?= $content['tag']['description'] ?>
      </div>
      <?php endif ?>

    <?php } ?>

  </div>

<?php } ?>