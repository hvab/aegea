function e2PastePic (pic) {
  // if (alt = $ ('#title').val ()) alt = ' ' + alt
  var alt = ''
  var text = ''
  if ($('#formatter-id').val() === 'neasden') text = pic + alt
  if (!text) return
  var field = document.getElementById('text')
  field.focus()
  if (field.selectionStart || field.selectionStart === 0) {
    var selStart = field.selectionStart
    var selEnd = field.selectionEnd
    var paragraphStart = selStart
    var textToPaste = text + '\n\n'
    var insertedWithCommand = false

    while ((field.value.charAt(paragraphStart) !== '\r') && (field.value.charAt(paragraphStart) !== '\n') && (paragraphStart > 0)) {
      paragraphStart -= 1
    }
    while ((field.value.charAt(paragraphStart) === '\r') || (field.value.charAt(paragraphStart) === '\n')) {
      paragraphStart += 1
    }

    // try to keep native undo stack intact when browser allows it
    if (typeof document.execCommand === 'function') {
      try {
        field.setSelectionRange(paragraphStart, paragraphStart)
        insertedWithCommand = document.execCommand('insertText', false, textToPaste)
      } catch (error) {
        insertedWithCommand = false
      }
    }

    if (!insertedWithCommand) {
      field.value = field.value.substring(0, paragraphStart) + textToPaste +
        field.value.substring(paragraphStart, field.value.length)
    }

    var shift = textToPaste.length
    field.setSelectionRange(selStart + shift, selEnd + shift)
  } else {
    field.value += '\r\n\r\n' + text
  }

  // make onchange event to update submittability
  if ('createEvent' in document) {
    var evt = document.createEvent('HTMLEvents')
    evt.initEvent('change', false, true)
    field.dispatchEvent(evt)
  } else {
    field.fireEvent('onchange')
  }

  field.focus()
}

export default e2PastePic
