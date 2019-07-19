<?php if (array_key_exists ('notes-list', $content) and count ($content['notes-list']) > 0) { ?>

<div class="e2-note-list e2-text">
<?php foreach ($content['notes-list'] as $note): ?>
<p class="<?= $note['visible?']? '' : 'e2-hidden' ?>">
  <a href="<?= $note['href'] ?>" title=""><?= $note['title']?></a>
  <?php if ($note['favourite?']) { ?>
  ★
  <?php } ?>
  <?php if (array_key_exists ('text-fragment', $note)) { ?>
  <br /><?= $note['text-fragment']?>
  <?php } ?>
</p>
<?php endforeach; ?>
</div>

<?php } ?>
