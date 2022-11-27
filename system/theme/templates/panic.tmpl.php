<!DOCTYPE html>
<html>

<!-- <?= $content['exception-message'] ?> -->

<head>
<title><?= $content['title'] ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta charset="utf-8"/>
<style type="text/css">

  html, body { height: 100%; margin: 0; padding: 0 }
  body { padding: 20px }
  pre { font-size: 14px; line-height: 18px }

  /* Next lines must be the same as in e2-unavailable.scss */
  .e2-logo-svg { width: 32px; height: 32px; fill: #f8c850; color: #f8c850; }
  .e2-unavailable { display: table; width: 100%; height: 100% }
  .e2-unavailable>div { display: table-cell; width: 100%; vertical-align: middle }
  .e2-heading .e2-logo-svg { width: 80px; height: 80px; margin: 0 0 1em 0 }
  .e2-unavailable .e2-logo-svg { width: 160px; height: 160px; margin: auto }

</style>
</head>
<body>

  <?php if (array_key_exists ('exception-string', $content)) { ?>
    <pre><?= $content['exception-string'] ?> </pre>
    <div class="e2-logo-svg"><?= _SVG ('aegea') ?></div>
  <?php } else { ?>
    <div class="e2-unavailable"><div><div class="e2-logo-svg"><?= _SVG ('aegea') ?></div></div></div>
  <?php } ?>

</body>

</html>
