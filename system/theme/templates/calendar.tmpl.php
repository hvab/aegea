<?php if (array_key_exists ('years', $content['calendar'])): ?>

<div class="e2-band e2-band-full-size">
<div class="e2-band-scrollable js-band-scrollable">
<div class="js-band-scrollable-inner">
<nav>
<?php foreach ($content['calendar']['years'] as $year): ?>

<?php if ($year['this?'] and $content['class'] == 'year'): ?>
<div class="band-item band-item-current"><span class="band-item-inner"><?= _DT ('Y', $year['start-time']) ?></span></div>
<?php elseif ($year['this?']): ?>
<div class="band-item band-item-parent"><a class="band-item-inner" href="<?= $year['href'] ?>"><?=  (_DT ('Y', $year['start-time'])) ?></a></div>
<?php elseif ($year['fruitful?']): ?>
<div class="band-item"><a class="band-item-inner" href="<?= $year['href'] ?>"><?=  (_DT ('Y', $year['start-time'])) ?></a></div>
<?php elseif ($year['real?']): ?>
<div class="band-item band-item-disabled"><span class="band-item-inner"><?=  (_DT ('Y', $year['start-time'])) ?></span></div>
<?php endif; ?>

<?php endforeach ?>
</nav>
</div>
</div>
</div>

<?php endif ?>


<?php if (array_key_exists ('months', $content['calendar'])): ?>

<div class="e2-band e2-band-full-size">
<div class="e2-band-scrollable js-band-scrollable">
<div class="js-band-scrollable-inner">
<nav>
<?php foreach ($content['calendar']['months'] as $month): ?>

<?php if ($month['this?'] and $content['class'] == 'month'): ?>
<div class="band-item band-item-current"><span class="band-item-inner"><?= _DT ('{month}', $month['start-time']) ?></span></div>
<?php elseif ($month['this?']): ?>
<div class="band-item band-item-parent"><a class="band-item-inner" href="<?= $month['href'] ?>"><?=  (_DT ('{month}', $month['start-time'])) ?></a></div>
<?php elseif ($month['fruitful?']): ?>
<div class="band-item"><a class="band-item-inner" href="<?= $month['href'] ?>"><?=  (_DT ('{month}', $month['start-time'])) ?></a></div>
<?php elseif ($month['real?']): ?>
<div class="band-item band-item-disabled"><span class="band-item-inner"><?=  (_DT ('{month}', $month['start-time'])) ?></span></div>
<?php endif; ?>

<?php endforeach ?>
</nav>
</div>
</div>
</div>

<?php endif ?>


<?php if (array_key_exists ('days', $content['calendar'])): ?>

<div class="e2-band e2-band-full-size">
<div class="e2-band-scrollable js-band-scrollable">
<div class="js-band-scrollable-inner">
<nav>
<?php foreach ($content['calendar']['days'] as $day): ?>

<?php if ($day['this?'] and $content['class'] == 'day'): ?>
<div class="band-item band-item-current"><span class="band-item-inner"><?= _DT ('j', $day['start-time']) ?></span></div>
<?php elseif ($day['this?']): ?>
<div class="band-item band-item-parent"><a class="band-item-inner" href="<?= $day['href'] ?>"><?= _DT ('j', $day['start-time']) ?></a></div>
<?php elseif ($day['fruitful?']): ?>
<div class="band-item"><a class="band-item-inner" href="<?= $day['href'] ?>"><?= _DT ('j', $day['start-time']) ?></a></div>
<?php elseif ($day['real?']): ?>
<div class="band-item band-item-disabled"><span class="band-item-inner"><?= _DT ('j', $day['start-time']) ?></span></div>
<?php endif; ?>

<?php endforeach ?>
</nav>
</div>
</div>
</div>

<?php endif ?>