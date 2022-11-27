<?php if (array_key_exists ('tags', $content)) { ?>
<?php if ($content['class'] == 'tags') { ?>

<div class="e2-tags">
<?php foreach ($content['tags']['each'] as $tag): ?>
<a
  href="<?= @$tag['href'] ?>"
  class="e2-tag"
  style="opacity: <?= 0.3 + 0.7 * pow ($tag['weight'], 0.7) ?>"
><?php if (!$tag['visible?']) { ?><span class="e2-svgi e2-svgi-lock-nano"><?= _SVG ('lock-nano') ?></span> <?php } ?><?=@$tag['tag']?></a>
<?php endforeach ?>
</div>

<?php } ?>
<?php } ?>
