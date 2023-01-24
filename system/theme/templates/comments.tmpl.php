<?php if ($content['class'] == 'note') { ?>
  <a name="comments"></a>
<?php } ?>



<?php if (array_key_exists ('comments', $content)) { ?>
  <?php if ($content['class'] != 'comment-edit') { ?>
    <?php if (array_key_exists ('each', $content['comments'])) { ?>
      <div class="e2-comments <?= $content['notes']['only']['hidden?']? 'e2-comments-hidden' : '' ?>">
        <?php if (!array_key_exists ('only', $content['comments']['each'])) { ?>
          <?php _T ('comments-heading'); ?>
        <?php } ?>

        <?php foreach ($content['comments']['each'] as $comment): ?>
        <?php $content['_']['_comment'] = $comment; ?>
        <?php _T ('comment') ?>
        <?php endforeach ?>
      </div>
    <?php } ?>
  <?php  } ?>
<?php } ?>



<?php if (array_key_exists ('toggle', $content['comments'])) { ?>
  <div class="e2-comments-toggle">
    <form action="<?= $content['comments']['toggle']['form-action'] ?>" method="post">
      <input type="hidden" name="token" value="<?= $content['sign-in']['token'] ?>" />
      <input type="submit" class="e2-button" value="<?= $content['comments']['toggle']['submit-text'] ?>" />
    </form>
  </div>
<?php } ?>



<?php if ($content['comments']['display-form?']) { ?>
  <?php _T_FOR ('form-comment') ?>
<?php } ?>
