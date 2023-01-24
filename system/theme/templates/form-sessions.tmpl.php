<form
  action="<?= @$content['form-sessions']['form-action'] ?>"
  method="post"
>

<input
  type="hidden"
  id="token"
  name="token"
  value="<?= $content['sign-in']['token'] ?>"
/>

<button type="submit" class="e2-button" id="submit-button">
  <?= @$content['form-sessions']['submit-text'] ?>
</button>

</form>

<p></p>
