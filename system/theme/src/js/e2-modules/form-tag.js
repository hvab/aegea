function initFormTag () {
  var $formTag = $('#form-tag')

  if ($formTag.length) return

  var $submitButton = $formTag.find('#submit-button')

  $('.required').bind('input blur cut copy paste keypress', updateSubmittability)
  updateSubmittability()

  function updateSubmittability () {
    const shouldBeDisabled = /^ *$/.test($('#tag').val()) || /^ *$/.test($('#urlname').val())

    if (shouldBeDisabled) {
      $submitButton.prop('disabled', true)
    } else {
      $submitButton.prop('disabled', false)
    }
  }
}

export default initFormTag
