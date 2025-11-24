/* read the value of an `<input accept="…">` attribute and return helpers that can
 * (a) recognise allowed file extensions and (b) show that list back to a human */
function e2ParseAcceptExtensions (acceptAttr) {
  if (typeof acceptAttr !== 'string') return null

  // values are generated as ".ext, .ext" and our accept attributes never include MIME types
  var extensions = acceptAttr.split (', ').map (function (token) {
    return token.toLowerCase ()
  })

  if (!extensions.length) return null

  function allows (filename) {
    if (typeof filename !== 'string') return false

    var lastDot = filename.lastIndexOf ('.')
    if (lastDot === -1) return false

    var ext = '.' + filename.slice (lastDot + 1).toLowerCase ()
    return extensions.indexOf (ext) !== -1
  }

  return {
    allows: allows,
    extensions: extensions
  }
}

export default e2ParseAcceptExtensions
