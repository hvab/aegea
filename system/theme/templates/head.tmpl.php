<meta http-equiv="Content-Type" content="text/html; charset=<?= $content['output-charset'] ?>" />

<base href="<?= $content['base-href'] ?>" />
<link rel="shortcut icon" type="<?= $content['blog']['favicon-type'] ?>" href="<?= $content['blog']['favicon-href'] ?>" />

<?php foreach ($content['stylesheets'] as $stylesheet): ?>
<link rel="stylesheet" type="text/css" href="<?= $stylesheet ?>" />
<?php endforeach ?>

<?php foreach ($content['newsfeeds'] as $newsfeed): ?>
<link rel="alternate" type="<?= $newsfeed['type'] ?>" title="<?= $newsfeed['title'] ?>" href="<?= $newsfeed['href'] ?>" />
<?php endforeach ?>

<?php foreach ($content['navigation-links'] as $link): ?>
<link rel="<?= $link['rel'] ?>" id="<?= $link['id'] ?>" href="<?= $link['href'] ?>" />
<?php endforeach ?>

<?php if (array_key_exists ('manifest-href', $content)): ?>
<link rel="manifest" href="<?= $content['manifest-href'] ?>">
<?php endif ?>

<?php if (array_key_exists ('robots', $content)): ?>
<meta name="robots" content="<?= $content['robots'] ?>" />
<?php endif ?>

<?php if (array_key_exists ('summary', $content)): ?>
<meta name="description" content="<?= $content['summary'] ?>" />
<meta name="og:description" content="<?= $content['summary'] ?>" />
<?php endif ?>

<?php foreach ($content['og-images'] as $image): ?>
<meta property="og:image" content="<?= $image ?>" />
<?php endforeach ?>

<meta name="twitter:card" content="<?= $content['twitter-card'] ?>" />

<meta name="viewport" content="<?= $content['meta-viewport'] ?>">

<title><?= $content['title'] ?></title>
<meta name="og:title" content="<?= $content['title'] ?>" />

<meta name="og:url" content="<?= $content['current-href'] ?>" />

<?php _X ('head-extras') ?>

