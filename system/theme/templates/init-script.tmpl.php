<script type="text/javascript">
document.e2 = document.e2 || {}
document.e2.serverTime = <?= time () ?> 
document.e2.cookiePrefix = <?= $content['engine']['cookie-prefix'] ?> 
document.e2.basePath = <?= $content['engine']['base-path'] ?> 
<?php if (array_key_exists ('last-modifieds-by-id', $content)) { ?>
document.e2.noteLastModifiedsById = <?= $content['last-modifieds-by-id'] ?> 
<?php } ?>
</script>
