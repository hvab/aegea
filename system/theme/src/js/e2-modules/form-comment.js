import swing from '../lib/swing'

function initFormComment () {
  const mailMask = /^\s*([a-z0-9_.-])+@[a-z0-9-]+\.([a-z]{2,11}\.)?[a-z]{2,11}\s*$/i
  const $formComment = $('#form-comment')
  const $name = $formComment.find('#name')
  const $email = $formComment.find('#email')
  const $gips = $formComment.find('.e2-gips')
  const $emailFields = $formComment.find('.e2-email-fields')
  const $submitButton = $formComment.find('#submit-button')
  const cookieName = $formComment.data('cookie')
  const cookieValue = $formComment.data('cookie-value')

  function getWindowSizeAndPosition () {
    let myWidth = window.innerWidth
    let myHeight = window.innerHeight
    let myTop = window.screenY
    let myLeft = window.screenX

    let WindowSizeAndPosition = {}
    WindowSizeAndPosition.width = myWidth
    WindowSizeAndPosition.height = myHeight
    WindowSizeAndPosition.top = myTop
    WindowSizeAndPosition.left = myLeft

    return (WindowSizeAndPosition)
  }

  function updateSubmitButtonEnabledness () {

    var notLoggedInToGIP = $gips.hasClass('required')
    var shouldBeEnabled = $('#text').val()

    if (notLoggedInToGIP && $emailFields.is(':visible')) {

      if ($name.length && !$name.val()) {
        shouldBeEnabled = false
      }

      if ($email.length && !mailMask.test($email.val())) {
        shouldBeEnabled = false
      }

    }

    if (shouldBeEnabled) {
      $submitButton.prop('disabled', false)
      $submitButton.hide().show(0) // force repaint on stupid safari
    } else {
      $submitButton.prop('disabled', true)
      $submitButton.hide().show(0) // force repaint on stupid safari
    }
  }

  function setNospamCookie (cookieName, cookieValue) {
    const d = new Date(new Date().getTime() + 60 * 24 * 60 * 60 * 1000)
    document.cookie = cookieName + '=' + cookieValue + ';path=/;expires=' + d.toUTCString()
  }

  if ($formComment.length) {
    $('.required').on('input blur cut copy paste keypress', updateSubmitButtonEnabledness)
    updateSubmitButtonEnabledness()
    $formComment.on('submit', function () {

      var notLoggedInToGIP = $gips.hasClass('required')

      setNospamCookie(cookieName, cookieValue)

      if (
        !$gips.length
        || !$gips.is(':visible')
        || !notLoggedInToGIP
        || (
          notLoggedInToGIP && $emailFields.is(':visible') && $name.val() && mailMask.test($email.val())
        )
      ) {
        return true
      }

      swing($gips[0])

      return false
    }).show()
  }

  $('.e2-email-fields-revealer').on('click', function (e) {
    e.preventDefault()

    $emailFields.show()
    updateSubmitButtonEnabledness()
    $(this).hide()
  })

  $('.e2-gips a.e2-gip-link').on('click', function (e) {
    e.preventDefault()
    let href = $(this).attr('href')
    let windowSizeAndPosition = getWindowSizeAndPosition()
    const popupWidth = 600
    const popupHeight = 600
    let popupLeft = windowSizeAndPosition.left + (windowSizeAndPosition.width / 2) - (popupWidth / 2)
    let popupTop = windowSizeAndPosition.top + (windowSizeAndPosition.height / 2) - (popupHeight / 2)
    if (popupLeft < 0) popupLeft = 50
    if (popupTop < 0) popupTop = 50
    window.open(href, 'gips', 'left=' + popupLeft + ',top=' + popupTop + ',width=' + popupWidth + ',height=' + popupHeight + ',centerscreen')
  })

  window.oauthAuthorized = function (data) { // eslint-disable-line no-unused-vars
    $('.e2-hide-on-login').hide()
    $('.e2-gips').removeClass('required')

    $('.e2-gip-info')
      .find('.name').text(data.name).end()
      .find('.e2-gip-icon').html(data.gipIcon).end()
      .find('.e2-gip-logout-url').attr('href', data.logoutUrl).end()
      .show()
    updateSubmitButtonEnabledness()
  }
}

export default initFormComment
