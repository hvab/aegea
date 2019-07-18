if ($) $ (function () {
  document.e2 = document.e2 || {}

  // live updates window title

  var originalTitle = document.title

  $ ('input.e2-smart-title').bind ('input', function () {
    if (this.value) document.title = this.value
    else if (originalTitle) document.title = originalTitle
  })

  // retitle on scrolling

  var e2UpdateWindowTitleFromScrollPosition = function () {

    var y = $ (window).scrollTop ()
    var title = originalTitle
    var currentNoteId
    if (y > 0) {
      $ ('.e2-smart-title').each (function () {
        if ($ (this).position ().top > y + window.innerHeight) return false
        title = $ (this).text ()
        currentNoteId = $ (this).closest('.e2-note').attr('id').replace('e2-note-', '')
        if ($ (this).position ().top > y) return false
      })
    }
    document.title = title
    document.e2.currentNoteId = currentNoteId
  }

  if ($ ('.e2-smart-title').length > 1) {

    $ (window).bind ('scroll resize', e2UpdateWindowTitleFromScrollPosition)
    e2UpdateWindowTitleFromScrollPosition ()

  } else if ($ ('.e2-smart-title:not(input)').length === 1) {

    document.e2.currentNoteId = $ ('.e2-smart-title:not(input)').closest('.e2-note').attr('id').replace('e2-note-', '')

  }

})
