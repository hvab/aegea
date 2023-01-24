// https://gist.github.com/vast/cedf4e6f20e02a4b8da3dc36abce95cb

const FORBIDDEN_EVENT_SOURCES = ['input', 'textarea']
// const F_KEYCODE = 70
const ESC_KEYCODE = 27

const isInputEventApplicable = (e) => {
  const targetTag = e.target.tagName.toLowerCase()
  const isContentEditable = e.target.contentEditable === 'true' || e.target.contentEditable === 'plaintext-only'

  return FORBIDDEN_EVENT_SOURCES.indexOf (targetTag) < 0 && !isContentEditable
}

function initSearchHotKeys () {
  const $input = $ ('.js-search-query')
  if ($input.length == 0) return

  const $probe = $ ('<span />')
    .css ({ position: 'fixed', left: '-1000px', bottom: 0 })
    .appendTo ('body')

  const $document = $ (document)

  $document.on ('keydown', function (e) {

    if (e.keyCode !== ESC_KEYCODE) return
    e.preventDefault ()

    if ($input.is (":focus")) {
      $input[0].blur ()
    } else {
      if (!isInputEventApplicable (e)) return
      $input[0].focus ()
    }
  })

  // // command+F
  // $document.on ('keydown', function (e) {
  //   if (e.keyCode !== F_KEYCODE) return
  //   if ($input.is (":focus")) return

  //   if ((e.ctrlKey && !e.metaKey) || (e.metaKey && !e.ctrlKey)) {
  //     e.preventDefault ()
  //     $input[0].focus ()
  //   }
  // })

  $document.on ('keydown keypress', function (e) {
    const char = String.fromCharCode(e.charCode)
    const probeWidth = $probe.html (char).width ()

    if ($input.is (":focus")) return
    if (!isInputEventApplicable (e)) return
    if (!char || !char.length) return
    if ($ ('#e2-follow-sheet').hasClass('e2-show')) return
    if ($ ('#e2-login-sheet').hasClass('e2-show')) return

    if (probeWidth > 0 && !e.metaKey && !e.ctrlKey && !e.altKey) {
      e.preventDefault ()
      $input.val ($input.val () + char)
      $input[0].focus ()
    }
  })

}

export default initSearchHotKeys