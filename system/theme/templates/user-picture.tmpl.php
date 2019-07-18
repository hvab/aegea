<?php if (isset ($content['blog']['userpic-upload-action'])) { ?>

<a id="e2-userpic-upload-action" href="<?= $content['blog']['userpic-upload-action'] ?>"></a>

<div class="e2-user-picture-container e2-external-drop-target">
  <?php if (array_key_exists ('userpic-href', $content['blog'])) { ?>
    <?= _A ('<a href="'. $content['blog']['href']. '" class="nu"><img src="'. $content['blog']['userpic-changeable-href'] .'" alt="" title="'. _S ('gs--drag-userpic-here') .'" /></a>') ?> 
  <?php } ?>
  <span class="e2-user-picture-uploading" id="e2-user-picture-uploading"><?= _SVG ('spin-progress') ?></span>
</div>

<?php } else { ?>

<div class="e2-user-picture-container">
<?php if (array_key_exists ('userpic-href', $content['blog'])) { ?>
  <?= _A ('<a href="'. $content['blog']['href']. '" class="nu"><img src="'. $content['blog']['userpic-href'] .'" alt="" /></a>') ?> 
<?php } ?>
</div>

<?php } ?>