<?php $note = $content['_']['_note']; ?>
<?php unset ($content['_']['_note']); ?>

<div class="e2-note-snippet<?= $note['hidden?']? ' e2-note-hidden' : '' ?>">

<?php if (@$note['userpic-href']) { ?>
<div class="e2-note-author-picture">
  <img src="<?= $note['userpic-href'] ?>" alt="<?= @$note['source'] ?>" />
</div>
<?php } ?>

<?php if (@$note['author']) { ?>
<div class="e2-note-author-name">
<?= @$note['author'] ?>
</div>
<?php } ?>

<?php // THUMBS // ?>
<?php $thumbs = []; ?>
<?php if (empty ($note['_pubpreview'])) { ?>
<?php if (array_key_exists ('thumbs', $note)) $thumbs = $note['thumbs']; ?>
<?php } else { ?>
<?php if (array_key_exists ('og-images-thumbs', $note)) $thumbs = $note['og-images-thumbs']; ?>
<?php } ?>

<?php if (count ($thumbs)) { ?>

<?php if (!_AT ($note['href'])) { ?> 
<a href="<?= $note['href'] ?>" class="nu">
<?php } ?> 

<div class="e2-note-thumbs">
<?php if (0) { ?>
<?php foreach ($thumbs as $x) if ($x['is-available?'])  { ?><div class="e2-note-thumb <?php if ($note['has-highlighted-thumbs?'] and !$x['highlighted?']) { ?>e2-note-thumb-dimmed<?php } ?>" style="background-image: url('<?= $x['src'] ?>')"><?php if ($x['highlighted?']) { ?><mark><?php } ?><?php if ($x['highlighted?']) { ?></mark><?php } ?></div><?php } ?>
<?php } else { ?>
<?php foreach ($thumbs as $x) if ($x['is-available?']) { ?><div class="e2-note-thumb"><?php if ($x['highlighted?']) { ?><mark><?php } ?><img src="<?= $x['src'] ?>" width="<?= $x['width'] ?>" height="<?= $x['height'] ?>" class="<?php if ($note['has-highlighted-thumbs?'] and !$x['highlighted?']) { ?>e2-note-thumb-dimmed<?php } ?>" alt="" /><?php if ($x['highlighted?']) { ?></mark><?php } ?></div><?php } ?>
<?php } ?>
</div>

<?php if (!_AT ($note['href'])) { ?> 
</a>
<?php } ?> 

<?php } ?>

<div>

<?php if (empty ($note['_pubpreview'])): ?>
<?php if (array_key_exists ('edit-href', $note)): ?>
  <span class="admin-links admin-links-floating">
    <?php if (array_key_exists ('favourite-toggle-action', $note)) { ?>
      <span class="admin-icon">
        <form action="<?= $note['favourite-toggle-action'] ?>" method="post" class="nu">
          <input type="hidden" name="token" value="<?= $content['sign-in']['token'] ?>" />
          <button type="submit" href="<?= $note['favourite-toggle-action'] ?>" class="nu e2-admin-link e2-admin-item <?= ($note['favourite?']? 'e2-admin-item_on' : '') ?>" data-e2-js-action="toggle-favourite" data-e2-js-action-token="<?= $content['sign-in']['token'] ?>">
            <span class="e2-svgi">
              <span class="e2-toggle-state-off"><?= _SVG ('favourite-off') ?></span>
              <span class="e2-toggle-state-on"><?= _SVG ('favourite-on') ?></span>
              <span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span>
            </span>
          </button>
        </form>
      </span>
    <?php } ?>

    <span class="admin-icon">
      <a href="<?= $note['edit-href'] ?>" class="nu <?php if (array_key_exists ('only', $content['notes'])) {?>e2-edit-link<?php } ?>">
        <span class="e2-svgi"><?= _SVG ('edit') ?><span class="e2-attention-led js-unsaved-led" style="display: none"></span></span>
      </a>
    </span>
    
  </span>
<?php endif ?>
<?php endif ?>


<?php if (empty ($note['_pubpreview'])): ?>
<?php if ($note['scheduled?']) { ?><div class="e2-nonpublic-label"><?= _S ('gs--will-be-published') ?> <?=_DT ('j {month-g} Y, H:i', @$note['time'])?></div><?php } ?>
<?php endif ?>

<?php // TITLE // ?>
<h1>
<?php if (@$note['favourite?'] and !array_key_exists ('favourite-toggle-action', $note)) { ?>
<?= _A ('<a href="'. $note['href']. '"><span class="e2-note-favourite-title">'. $note['title']. '</span></a>') ?> 
<?php } else { ?>
<?= _A ('<a href="'. $note['href']. '">'. $note['title']. '</a>') ?> 
<?php } ?>
</h1>

</div>


<?php // TEXT // ?>

<?php if (array_key_exists ('snippet-text', $note) and $note['snippet-text'] != '') { ?>
<div class="e2-note-snippet-text">
<p><?= $note['snippet-text'] ?></p>
</div>
<?php } ?>


<?php // META: COMMENTS, READS, DATE, TAGS // ?>

<?php if (empty ($note['_pubpreview'])): ?>

<div class="e2-band e2-band-meta-size e2-note-meta">
<div class="e2-band-scrollable js-band-scrollable">
  <div class="js-band-scrollable-inner">
  <nav>

    <?php if ($note['comments-link?']): ?>
    <div class="band-item">
      <?php if ($note['comments-count']) { ?>
        <a class="band-item-inner" href="<?= $note['href-comments'] ?>"><span class="e2-svgi"><?= _SVG ('comments') ?></span> <?= $note['comments-count-text'] ?><?php if ($note['new-comments-count'] == 1 and $note['comments-count'] == 1) { ?>, <?= _S ('gs--comments-all-one-new') ?><?php } elseif ($note['new-comments-count'] == $note['comments-count']) { ?>, <?= _S ('gs--comments-all-new') ?><?php } ?></a>
      <?php } else { ?>
      <a class="band-item-inner" href="<?= $note['href-comments'] ?>"><span class="e2-svgi"><?= _SVG ('comments') ?></span> <?= _S ('gs--no-comments') ?></a>
      <?php } ?>
    </div>

    <?php if ($note['new-comments-count'] and $note['new-comments-count'] < $note['comments-count']) { ?>
    <div class="band-item admin-links">
      <a class="admin-link band-item-inner" href="<?=$note['href']?>#new"><?= $note['new-comments-count-text'] ?></a>
    </div>
    <?php } ?>
    <?php endif ?>

    <?php if (!empty ($note['preview-href'])) { ?>
    <div class="band-item admin-links">
      <a class="admin-link band-item-inner" href="<?= $note['preview-href'] ?>"><?= _S ('gs--secret-link') ?></a>
    </div>
    <?php } ?>

    <?php if (_READS ($note)) { ?>
    <div class="band-item">
      <div class="band-item-inner">
        <span><span class="e2-svgi"><?= _SVG ('read') ?></span> <?= _READS ($note) ?></span>
      </div>
    </div>
    <?php } ?>

    <?php if (!empty ($note['time'])) { ?>
    <div class="band-item">
      <div class="band-item-inner">
        <span title="<?=_DT ('j {month-g} Y, H:i, {zone}', $note['time'])?>"><?= _AGO ($note['time']) ?></span>
      </div>
    </div>
    <?php } ?>

    <?php $content['_']['_tags_line']['_prepend'] = ''; ?>
    <?php $content['_']['_tags_line']['_tags'] = $note['tags']; ?>
    <?php _T ('tags-line') ?>

  </nav>
  </div>
</div>
</div>

<?php endif; ?>

</div>