<?php _T ('author-menu') ?>
<div style="margin: 20px 60px">




<br /><br /><br />




<?php _X ('header-pre') ?>
<?php _T ('user-picture') ?>

<h1>
  <?= _A ('<a href="'. $content['blog']['href']. '"><span id="e2-blog-title">'. $content['blog']['title']. '</span></a>') ?>
</h1>

<?php if ($content['frontpage?']) {?>
<p><?= $content['blog']['description'] ?></p>
<?php } ?>

<?php _T_FOR ('search') ?>
<a class="e2-rss-button" href="<?=@$content['blog']['rss-href']?>"><?= _S ('gs--rss') ?></a>

<?php _X ('header-post') ?>




<br /><br /><br />




<?php _T ('message') ?>
<?php _T ('heading') ?>




<br /><br /><br />




<?php _T ('welcome') ?>
<?php _T ('notes') ?>
<?php _T ('drafts') ?>
<?php _T ('notes-list') ?>
<?php _T ('tags') ?>
<?php _T ('nothing') ?>
<?php _T ('sessions') ?>
<?php _T ('sources') ?>
<?php _T ('pages') ?>
<?php _T ('comments') ?>
<?php _T ('popular') ?>
<?php _T ('tags-menu') ?>
<?php _T ('unsubscribe') ?>
<?php _T ('form') ?>




<br /><br /><br />




<?php _X ('footer-pre') ?>
© <span id="e2-blog-author"><?= @$content['blog']['author'] ?></span>, <?=$content['blog']['years-range']?>
<?=$content['engine']['about']?>
<?php if ($content['sign-in']['done?']) { ?>
&nbsp;&nbsp;&nbsp;
<span title="<?= _S ('gs--pgt') ?>"><?=$content['engine']['pgt']?> <?= _S ('gs--seconds-contraction') ?></span>
<?php } ?>

<?php _X ('footer-post') ?>

<?php _T ('login-element'); ?>


</div>
