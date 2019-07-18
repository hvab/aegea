import textEditorInit from './lib/text-editor'

if ($('#form-preferences').length) initForm()

function initForm () {
  textEditorInit(document.getElementById('blog-description'))

  $('#e2-template-selector').show()

  $('#blog-title').bind('input blur cut copy paste keypress', function () {
    const $title = $('#e2-blog-title')

    if ($title) $title.text(this.value ? this.value : $('#e2-blog-title-default').val())
  })

  $('#blog-author').bind('input blur cut copy paste keypress', function () {
    const $author = $('#e2-blog-author')

    if ($author) $author.text(this.value ? this.value : $('#e2-blog-author-default').val())
  })

  $('#notes-per-page').bind('change blur', function () {
    // is this.value === NaN then use 10 as default value
    if (parseInt(this.value) !== parseInt(this.value)) this.value = 10
    this.value = Math.min(Math.max(this.value, 3), 100)
  })

  $('#email-notify').bind('change', function () {
    // if (!this.value)
    $('#email').focus()
  })

  $('#email').bind('input change blur', function () {
    if (!this.value) $('#email-notify').removeAttr('checked')
  })

  $('.e2-template-preview').click(function () {
    const $this = $(this)
    $('.e2-template-preview').attr('class', 'e2-template-preview')
    $this.addClass('e2-current-template-preview')
    $('#template').val($this.attr('value'))
    $('.e2-template-preview-link').attr('href', $this.data('preview-url'))
  })
}
