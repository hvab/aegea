function e2CanUploadThisFile (file) {
  var ext = ''
  var dot = file.lastIndexOf('.')

  if (dot !== -1) ext = file.substr(dot + 1)

  return /^gif|jpe?g|png|svg|mp3$/i.test(ext)
}

export default e2CanUploadThisFile
