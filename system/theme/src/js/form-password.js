if ($('#password').length) {
  $('.required').bind('input blur cut copy paste keypress', updateSubmittability)
  updateSubmittability()
}

function updateSubmittability () {
  const shouldBeDisabled = /^ *$/.test($('#password').val())

  if (shouldBeDisabled) {
    $('#submit-button').attr('disabled', 'disabled')
  } else {
    $('#submit-button').removeAttr('disabled')
  }
}
