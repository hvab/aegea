<div class="common">

<div class="flag"></div>

<div class="content">

<div class="e2-heading">        
  <span class="admin-links-floating">
    <span class="e2-ajax-loading" style="opacity: 0"><span class="e2-svgi e2-svgi-heading"><?= _SVG ('spin') ?></span></span>
  </span>
  <h2>
    <?php if (array_key_exists ('heading', $content)) { ?>
    <?= $content['heading'] ?>
    <?php } ?>
  </h2>
</div>

<div class="form-control">
   <?php _T ('message') ?>
</div>

<?php if ($content['form-install']['installation-possible?']) { ?>

<?php _JS ('form-install') ?>

<form
  id="form-install"
  action="<?= @$content['form-install']['form-action'] ?>"
  method="post"
>

<div class="form">

<input
  type="hidden"
  id="browser-offset"
  name="browser-offset"
  value="unknown"
/>

<script>
d = new Date ()
document.getElementById ('browser-offset').value = - d.getTimezoneOffset()
</script>

<a id="e2-check-db-config-action" href="<?= $content['form-install']['form-check-db-config-action'] ?>"></a>
<a id="e2-list-databases-action" href="<?= $content['form-install']['form-list-databases-action'] ?>"></a>

<div class="form-part">

<div class="form-control">
    <p><?= _S ('gs--db-parameters')?>:</p>
</div>

<div class="form-control">
  <div class="form-label input-label">
    <label><?= _S ('ff--db-host')?></label>
  </div>
  <div class="form-element">
    <input type="text"
      name="db-server"
      id="db-server"
      class="text input-editable e2-livecheckable db-server-ok db-user-password-ok db-database-ok db-everything-ok width-3"
      value="<?= @$content['form-install']['db-server'] ?>"
    />
  </div>
</div>

<div class="form-control">
  <div class="form-label input-label">
    <label><?= _S ('ff--db-username-and-password')?></label>
  </div>
  <div class="form-element">
    <input type="text"
      name="db-user"
      id="db-user"
      class="text input-editable e2-livecheckable db-user-password-ok db-database-ok db-everything-ok width-2"
      value="<?= @$content['form-install']['db-user'] ?>"
    />
  </div>
  <div class="form-element">
    <input type="text"
      name="db-password"
      id="db-password"
      class="text input-editable e2-livecheckable db-user-password-ok db-database-ok db-everything-ok width-2"
      value="<?= @$content['form-install']['db-password'] ?>"
    />
  </div>
</div>

<div class="form-control">
  <div class="form-label input-label">
    <label><?= _S ('ff--db-name') ?></label>
  </div>
  <div class="form-element">
    <input type="text"
      name="db-database"
      id="db-database"
      class="text input-editable e2-livecheckable db-database-ok db-everything-ok width-2"
      value="<?= @$content['form-install']['db-database'] ?>"
    />
    <select id="db-database-list" name="db-database-selected"
      class="e2-select e2-livecheckable e2-verified db-database-ok db-everything-ok width-2"
      style="display: none" size="1">
    </select>
    <div class="form-control-sublabel">
      <?= _S ('gs--ask-hoster-how-to-create-db') ?>
    </div>
  </div>
</div>

<div class="form-control" id="db-database-incomplete" style="display: none">
  <div class="e2-wrong width-3"><?= _S ('er--db-data-incomplete') ?></div>
</div>

<div class="form-control" id="db-database-exists" style="display: none">
  <div class="width-3"><?= _S ('gs--data-exists') ?></div>
</div>

</div>

<div class="form-part">

<div class="form-control">
  <p><?= _S ('gs--password-for-blog') ?>:</p>
</div>

<div class="form-control">
  <div class="form-element">
    <input type="text" class="text input-editable width-2" name="password" id="password"
    />
  </div>
</div>

<div class="form-control">
  <div class="form-element">
    <button type="submit" id="submit-button" class="e2-submit-button">
      <?= @$content['form-install']['submit-text'] ?>
    </button>
    <span class="e2-keyboard-shortcut"><?= _SHORTCUT ('submit') ?></span>
  </div>
</div>

</div>

</div>

</form>

</div>

<?php } else { ?>

<form>

<div class="form">
  
<div class="form-control submit-box">
  <div class="form-element">
    <button type="submit" id="submit-button" class="e2-submit-button">
      <?= @$content['form-install']['retry-text'] ?>
    </button>
  </div>
</div>

</div>

</form>

<?php } ?>

</div>
</div>