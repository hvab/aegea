<?php

if (array_key_exists ('pages', $content) and !empty ($content['pages'])) {

	$larr = $rarr = '';

	$prev_link = $next_link = $prev_html = $next_html = $need_pager = false;
	
	if ($content['pages']['prev-href']) {
		$prev_link = '<a href="'. $content['pages']['prev-href'] .'">'. $content['pages']['prev-title'] .'</a>';
		if ($content['pages']['prev-jump?']) $prev_link = $prev_link .'   · · ·';
		$larr = '&larr; ';
		$need_pager = true;
	} elseif ($content['pages']['prev-title']) {
		$prev_link = '<span class="unavailable">'. strip_tags ($content['pages']['prev-title']) .'</span>';
		$larr = '<span class="e2-page-unavailable">&larr;</span> ';
		$need_pager = true;
	}

	if ($content['pages']['next-href']) {
		$next_link = '<a href="'. $content['pages']['next-href'] .'">'. $content['pages']['next-title'] .'</a>';
		if ($content['pages']['next-jump?']) $next_link = '· · ·   '. $next_link;
		$rarr = ' &rarr;';
		$need_pager = true;
	} elseif ($content['pages']['next-title']) {
		$next_link = '<span class="unavailable">'. strip_tags ($content['pages']['next-title']) .'</span>';
		$rarr = ' <span class="e2-page-unavailable">&rarr;</span>';
		$need_pager = true;
	}

	if (@$content['pages']['timeline?']) {
		$need_pager = false;
	}

  if ($need_pager and $prev_link) {
		$prev_html = (
			'<div class="e2-pages-prev">'. $prev_link .'</div>'
		);
	}

  if ($need_pager and $next_link) {
		$next_html = (
			'<div class="e2-pages-next">'. $next_link .'</div>'
		);
	}


?>

<?php if ($need_pager) { ?>
<div class="e2-pages">
<div class="e2-pages-prev-next">

<?= $prev_html ?><div class="e2-pages-between"><span class="e2-keyboard-shortcut"><?= $larr ?><?= _SHORTCUT ('navigation') ?><?= $rarr ?></span></div><?= $next_html ?>

</div>
</div>
<?php } ?>

<?php } ?>