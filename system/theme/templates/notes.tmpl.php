<?php if (@$content['rose-debug-info']) { ?>
<pre style="display: none; background: #404040; color: #fff; padding: 20px; margin-bottom: 2em; font-size: 12px">
Rose debug info
---------------

<?= $content['rose-debug-info'] ?>
</pre>
<?php } ?>

<?php if ($content['class'] == 'drafts') { ?>
<div class="e2-notes-unsaved" id="e2-notes-unsaved"><?= _S ('gs--unsaved-changes') ?></div>
<p id="e2-unsaved-note-prototype" style="display: none"><a href="" class="e2-admin-link nu"><u></u></a><span class="e2-unsaved-led"></span></p>
<?php } ?>

<?php if (@$content['pages']['timeline?']) _T ('pages-later') ?>

<?php foreach ($content['notes'] as $note) { ?>
<?php $content['_']['_note'] = $note; ?>

<?php if ($content['class'] === 'drafts') {?>
<?php _T ('note-preview') ?>
<?php } elseif (in_array ($content['class'], ['found', 'tag', 'day'])) { ?>
<?php _T ('note-snippet') ?>
<?php } elseif ($note['scheduled?'] and $content['class'] !== 'note') { ?>
<?php _T ('note-snippet') ?>
<?php } else {?>
<?php _T ('note') ?>
<?php } ?>

<?php } ?>

<?php if (@$content['pages']['timeline?']) _T ('pages-earlier') ?>
