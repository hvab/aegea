import e2Ajax from './e2Ajax'

function e2RenameFile (options) {
  var url = $('#e2-file-rename-action').attr('href')

  if (url.indexOf('?go=') == -1) {
    url += '?'
  } else {
    url += '&'
  }

  if ($('#form-note').length) {
    url += 'entity=note&entity-id=' + $('#note-id').val()
  } else if ($('#form-tag').length) {
    url += 'entity=tag&entity-id=' + $('#tag-id').val()
  } else {
    return false
  }

  return e2Ajax({
    url: url,
    data: {'file': options.file, 'new-name': options.newName},
    success: options.success,
    error: options.error,
    complete: options.complete,
    abort: options.abort
  })
}

export default e2RenameFile
