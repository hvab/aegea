<!DOCTYPE html>
<html>

<head>

<?php _LIB ('jquery') ?>
<?php _LIB ('pseudohover') ?>
<?php _LIB ('smart-title') ?>


<e2:head-data />

<?php _T ('init-script') ?>

<e2:scripts-data />

<?= @$content['embed']['pre-head-end'] ?>

</head>

<body <?php if (@$content['body-uploads-enabled?']) { ?>class="e2-external-drop-target e2-external-drop-target-body e2-external-drop-target-altable"<?php } ?>>

<?php _T_FOR ('form-install') ?>
<?php _T_FOR ('form-login') ?>

<?php if (@$content['blog']['show-subscribe-button?']) { ?>
<?php _X ('subscribe-sheet') ?>
<?php } ?>

<?php if ($content['engine']['installed?']) { ?>
<?php _T ('layout'); ?>
<?php } ?>

<?= @$content['embed']['pre-body-end'] ?>

</body>

<?php _CSS ('main') ?>
<?php _JS ('main') ?>

<?php if ($content['sign-in']['done?']) { ?>
<?php _CSS ('admin') ?>
<?php _JS ('admin') ?>
<?php } ?>

<?php _CSS ('overrides') ?>

</html>

<!-- <?=$content['engine']['version-description']?> -->
