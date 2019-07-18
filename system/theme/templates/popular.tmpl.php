<?php if (array_key_exists ('popular', $content)) { ?>
<?php if (array_key_exists ('each', $content['popular'])) { ?> 
<?php if ($content['class'] == 'note' or $content['class'] == 'themepreview' or $content['class'] == '404') { ?>

<div class="e2-section-heading">
  <?=$content['popular']['title']?>
</div>

<div class="e2-popular">

  <?php foreach ($content['popular']['each'] as $item) { ?>
    <?php if (!$item['current?']) { ?><p><a href="<?= $item['href'] ?>" title="<?=_DT ('j {month-g} Y, H:i', $item['time'])?>"><?= $item['title'] ?></a></p><?php } ?>
  <?php } ?>

</div>

<?php } ?>
<?php } ?>
<?php } ?>
