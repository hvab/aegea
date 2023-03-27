function e2CanUploadThisFile (filename, extRegex) {
  var ext = ''
  var dotPos = filename.lastIndexOf('.')

  if (dotPos !== -1) ext = filename.substr(dotPos + 1)

  return extRegex.test(ext)
}

export default e2CanUploadThisFile
