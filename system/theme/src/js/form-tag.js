if ($('#form-tag').length) {
  $.ajaxSetup({ type: 'post', timeout: 10000 })

  $('.required').bind('input blur cut copy paste keypress', updateSubmittability)
  updateSubmittability()
}

function updateSubmittability () {
  const shouldBeDisabled = /^ *$/.test($('#tag').val()) || /^ *$/.test($('#urlname').val())

  if (shouldBeDisabled) {
    $('#submit-button').attr('disabled', 'disabled')
  } else {
    $('#submit-button').removeAttr('disabled')
  }
}
