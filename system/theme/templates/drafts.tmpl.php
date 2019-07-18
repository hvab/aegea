<?php if ($content['class'] == 'drafts') { ?>
<div class="e2-notes-unsaved" id="e2-notes-unsaved"><?= _S ('gs--unsaved-changes') ?></div>
<p id="e2-unsaved-note-prototype" style="display: none"><a href="" class="e2-admin-link nu"><u></u></a><span class="e2-unsaved-led"></span></p>
<?php  } ?>

<?php foreach ($content['drafts'] as $draft) { ?>

<div class="e2-draft-preview" id="e2-draft-<?= $draft['_']['_id'] ?>">
<a href="<?= $draft['href'] ?>" class="e2-admin-link nu">
  <div class="e2-draft-preview-box">
    <span class="e2-unsaved-led" style="display: none"></span>
    <div class="e2-draft-preview-content">
    <?php if ($thumb = $draft['thumbs'][0]) { ?>
      <img src="<?= $thumb['href']?>" width="<?= $thumb['width']?>" height="<?= $thumb['height']?>" alt="" />
    <?php } ?>

    <?php if (array_key_exists ('userpic-href', $draft)) { ?>
    <div class="e2-draft-preview-author-picture">
      <img src="<?= $draft['userpic-href'] ?>" alt="<?= @$draft['source'] ?>" />
    </div>
    <?php } ?>
  
    <div class="e2-draft-preview-text">
      <?php if (array_key_exists ('author', $draft)) { ?>
      <b><?= @$draft['author'] ?></b><br />
      <?php } ?>
      <?= $draft['text-fragment']?>
    </div>
    </div>
  </div>
  <u><?= $draft['title']?></u>
</a>
</div>

<?php } ?>
