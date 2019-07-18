<?php if ($content['class'] == 'note') { ?>
<a name="comments"></a>
<?php } ?>

<?php if (array_key_exists ('comments', $content)) { ?>
<?php if (@$content['form'] != 'form-comment') { ?>
<?php if (array_key_exists ('each', $content['comments'])) { ?>

<div class="e2-comments">

<?php if (!array_key_exists ('only', $content['comments']['each'])) { ?>
<?php _T ('comments-heading'); ?>
<?php } ?>


<?php # THE COMMENTS # ?>

<?php foreach ($content['comments']['each'] as $comment): ?>


<?php if ($comment['first-new?']) { ?><a name="new"></a><?php } ?>
      
<div class="e2-comment-and-reply">

<div class="<?= $comment['spam-suspect?']? 'e2-spam' : '' ?>">

  <div class="e2-comment">
    
    <div class="e2-comment-userpic-area">
      <?php if (!empty ($comment['userpic-href']) and !empty ($comment['name-href'])) { ?>
      <a href="<?= $comment['name-href'] ?>" class="nu"><img src="<?= $comment['userpic-href'] ?>" /></a>
      <?php } elseif (!empty ($comment['userpic-href'])) { ?>
      <img src="<?= $comment['userpic-href'] ?>" />
      <?php } ?>
    </div>
  
    <div class="e2-comment-content-area">
  
      <span
        class="e2-comment-author e2-comment-piece-markable <?php if (@$comment['important?']) echo 'e2-comment-piece-marked' ?>"
      ><?php if ($comment['gip-used?']) { ?><span class="e2-svgi e2-svgi-smaller"><?= _SVG ($comment['gip']) ?></span> <?php } ?><span><?= @$comment['name'] ?></span></span>

      <span class="e2-comment-date" title="<?=_DT ('j {month-g} Y, H:i, {zone}', @$comment['time'])?>"><?= _AGO ($comment['time']) ?></span>
          
      <span class="e2-comment-actions-removed admin-links" style="display: none">  
        <?php if (array_key_exists ('removed-toggle-href', $comment)): ?>
        <a href="<?= $comment['removed-toggle-href'] ?>" class="nu e2-removed-toggle e2-toggle-on"><span class="e2-svgi"><span class="e2-toggle-state-on"><?= _SVG ('replace') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a>
        <?php endif; ?>
      </span>
      
      <div class="e2-comment-content e2-text">
      <?=@$comment['text']?>
      </div>

    </div>

    <?php if (array_key_exists ('edit-href', $comment) or array_key_exists ('removed-toggle-href', $comment)): ?>
    <div class="e2-comment-control-area">
      <span class="e2-comment-secondary-controls e2-comment-actions admin-links">
        <?php if (!$comment['replying?'] and array_key_exists ('reply-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['reply-href'] ?>" class="nu"><span class="e2-svgi"><?= _SVG ('reply') ?></span></a></span><?php endif; ?>
        <?php if (array_key_exists ('important-toggle-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['important-toggle-href'] ?>" class="nu e2-important-toggle <?= ($comment['important?']? 'e2-toggle-on' : '') ?>"><span class="e2-svgi"><span class="e2-toggle-state-off"><?= _SVG ('favourite-off') ?></span><span class="e2-toggle-state-on"><?= _SVG ('favourite-on') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a></span><?php endif ?>
        <?php if (array_key_exists ('edit-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['edit-href'] ?>" class="nu"><span class="e2-svgi"><?= _SVG ('edit') ?></span></a></span><?php endif ?>
        <?php if (array_key_exists ('removed-toggle-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['removed-toggle-href'] ?>" class="e2-removed-toggle nu"><span class="e2-svgi"><span class="e2-toggle-state-off"><?= _SVG ('trash') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a></span><?php endif ?>
      </span>
    </div>
    <?php endif ?>
  </div>

  <?php if (@$content['form'] != 'form-comment-reply' and $comment['replied?']) { ?>

  <div class="e2-comment e2-reply">

    <div class="e2-comment-userpic-area">
      <img src="<?= $content['blog']['userpic-href'] ?>" />
    </div>

    <div class="e2-comment-content-area">
    
      <span
        class="e2-comment-author e2-comment-piece-markable <?php if (@$comment['reply-important?']) echo 'e2-comment-piece-marked' ?>"
      ><?= @$comment['author-name'] ?></span>

      <?php if (array_key_exists ('reply-time', $comment)) { ?>
      <span class="e2-comment-date" title="<?=_DT ('j {month-g} Y, H:i, {zone}', @$comment['reply-time'])?>"><?= _AGO ($comment['reply-time']) ?></span>
      <?php } ?>

      <span class="e2-comment-actions-removed admin-links" style="display: none">  
        <?php if (array_key_exists ('removed-reply-toggle-href', $comment)): ?>
        <a href="<?= $comment['removed-reply-toggle-href'] ?>" class="nu e2-removed-toggle e2-toggle-on e2-pseudolink"><span class="e2-svgi"><span class="e2-toggle-state-on"><?= _SVG ('replace') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a>
        <?php endif; ?>
      </span>

      <div class="e2-comment-content e2-text" <?= $comment['reply-visible?']? '' : 'style="display: none"' ?>>
      <?=@$comment['reply']?>
      </div>
  
    </div>
  
    <?php if (array_key_exists ('edit-reply-href', $comment) or array_key_exists ('removed-reply-toggle-href', $comment)): ?>
    <div class="e2-comment-control-area">
      <span class="e2-comment-secondary-controls e2-comment-actions admin-links">
        <?php if (array_key_exists ('reply-important-toggle-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['reply-important-toggle-href'] ?>" class="nu e2-important-toggle <?= ($comment['reply-important?']? 'e2-toggle-on' : '') ?>"><span class="e2-svgi"><span class="e2-toggle-state-off"><?= _SVG ('favourite-off') ?></span><span class="e2-toggle-state-on"><?= _SVG ('favourite-on') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a></span><?php endif ?>
        <?php if (array_key_exists ('edit-reply-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['edit-reply-href'] ?>" class="nu"><span class="e2-svgi"><?= _SVG ('edit') ?></span></a></span><?php endif; ?>
        <?php if (array_key_exists ('removed-reply-toggle-href', $comment)): ?><span class="admin-icon"><a href="<?= $comment['removed-reply-toggle-href'] ?>" class="e2-removed-toggle nu"><span class="e2-svgi"><span class="e2-toggle-state-off"><?= _SVG ('trash') ?></span><span class="e2-toggle-state-thinking"><?= _SVG ('spin') ?></span></span></a></span><?php endif; ?>
      </span>
    </div>
    <?php endif ?>

  
  </div>
  
  <?php } ?>
    
</div>

</div>

<?php endforeach ?>

</div> <!-- e2-comments -->

<?php } ?>
<?php } ?>
<?php } ?>




<?php # OPEN / CLOSE # ?>

<?php if (array_key_exists ('toggle', $content['comments'])) { ?>
<div class="e2-comment-toggle">
<a class="e2-button" href="<?=$content['comments']['toggle']['href']?>"><?= $content['comments']['toggle']['text'] ?></a>
</div>
<?php } ?>





<?php if ($content['comments']['commentable-now?']) { ?>
  <?php _T_FOR ('form-comment') ?>
<?php } ?>
