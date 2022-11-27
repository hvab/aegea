function initFormTag () {
  var $formTag = $('#form-tag')

  if (!$formTag.length) return

  var $submitButton = $formTag.find('#submit-button')
  $('#tag').on('keydown', function (e) {
    if (e.which === 13) {
      $('#urlname').focus()
    }
  })

  $('#urlname').on('keydown', function (e) {
    if (e.which === 13) {
      $('#page-title').focus()
    }
  })

  $('#page-title').on('keydown', function (e) {
    if (e.which === 13) {
      $('#text').focus()
    }
  })

  $('.required').bind('input blur cut copy paste keypress', updateSubmittability)
  updateSubmittability()

  function updateSubmittability () {
    const shouldBeDisabled = /^(\.|\s)*$/.test($('#tag').val()) || /^ *$/.test($('#urlname').val())

    if (shouldBeDisabled) {
      $submitButton.prop('disabled', true)
      $submitButton.hide().show(0) // force repaint on stupid safari
    } else {
      $submitButton.prop('disabled', false)
      $submitButton.hide().show(0) // force repaint on stupid safari
    }
  }
}

export default initFormTag
