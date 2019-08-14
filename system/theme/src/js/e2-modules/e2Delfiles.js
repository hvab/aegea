function e2Delfiles (file) {
  var url = $('#e2-file-remove-action').attr('href') + '?'

  if ($('#form-note')) {
    url += 'entity=note&entity-id=' + $('#note-id').val()
  } else if ($('#form-tag')) {
    url += 'entity=tag&entity-id=' + $('#tag-id').val()
  } else {
    return false
  }

  return $.ajax({
    type: 'POST',
    data: {'file': file},
    timeout: 60000,
    url: url,
    contentType: 'application/x-www-form-urlencoded'
  })
}

export default e2Delfiles
