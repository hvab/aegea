import e2SpinningAnimationStartStop from './lib/e2SpinningAnimationStartStop'
import { isLocalStorageAvailable } from './lib/local-storage'
import { bindKeys } from './lib/keybindings'

import detect from './detect'

$(function () {
  if (!$('#form-note').length) return

  var initNoteId = $('#note-id').val()
  var initPO = getPageObject()
  var prevPO = initPO ? Object.assign({}, initPO) : getPageObject()
  var edited = false
  var changed = false
  var liveSaving = false
  var stampMask = /^ *(\d{1,2})\.(\d{1,2})\.(\d{2}|\d{4}) +(\d{1,2}):(\d{1,2}):(\d{1,2}) *$/

  // refresh page if it loads from back-forward cache
  // more: https://developer.mozilla.org/en-US/docs/Working_with_BFCache
  $(window).bind('pageshow', function (event) {
    if (event.originalEvent.persisted) {
      window.location.reload()
    }
  })

  if (document.e2.localCopies.initLocalSaver && document.e2.localCopies.loadLocalCopy) {
    document.e2.localCopies.loadLocalCopy()
    document.e2.localCopies.initLocalSaver()
  }

  $.ajaxSetup({ type: 'post', timeout: 10000 })

  function e2AjaxSave (opts) {
    opts = opts || {}

    $.ajax({
      data: $('form').serialize(),
      url: $('#e2-note-livesave-action').attr('href'),
      success: function (msg) {
        if (opts.onAjaxSuccess) opts.onAjaxSuccess()
        var ajaxresult

        try {
          ajaxresult = JSON.parse(msg)
        } catch (e) {
          if (opts.onError) opts.onError(e.message)
          return
        }

        if (ajaxresult['status'] === 'created') {
          var newdraftid = ajaxresult['id']
          if (window.history.replaceState) {
            window.history.replaceState(null, '', ajaxresult['note-edit-url'])
            $('.e2-admin-menu-new-selected').hide()
            $('.e2-admin-menu-new').show()
          }
          $('#note-id').val(newdraftid)

          removeLocalCopy()

          if (opts.onCreated) opts.onCreated(ajaxresult)

          initNoteId = null
        } else if (ajaxresult['status'] === 'saved') {
          $('#alias').val(ajaxresult['new-alias'])
          if (window.history.replaceState) {
            window.history.replaceState(null, '', ajaxresult['note-edit-url'])
          }

          removeLocalCopy()

          if (opts.onSaved) opts.onSaved(ajaxresult)

          initNoteId = null
        } else if (ajaxresult['status'] === 'error') {
          if (opts.onError) opts.onError(ajaxresult['message'])
        }
      },
      error: function (xhr) {
        if (opts.onAjaxError) opts.onAjaxError(xhr.responseText)
      },
      complete: function (xhr) {
        // $ ('#e2-console').html (xhr.responseText)

        if (opts.onAjaxComplete) opts.onAjaxComplete()
      }
    })
  }

  function e2UpdateSubmittability () {
    var stampOk = true
    if ($('#stamp').val()) {
      stampMask.test($('#stamp').val())
    }
    var shouldBeEnabled = (
      !/^ *$/.test($('#title').val()) &&
      !/^ *$/.test($('#text').val()) &&
      stampOk &&
      !liveSaving
    )
    if (shouldBeEnabled) {
      $('#submit-button').removeAttr('disabled')
    } else {
      $('#submit-button').attr('disabled', 'disabled')
    }
  }

  function e2LiveSaveError (errmsg) {
    $('#e2-console').html(errmsg)
    e2SpinningAnimationStartStop($('#livesaving'), 0)
    $('#livesaving').hide()
    $('#livesave-button, #livesave-button + .e2-unsaved-led').show()
    $('#livesave-error').show()
    $('#livesave-error').attr('title', errmsg)
  }

  function e2LiveSave () {
    if (liveSaving) return

    var currentPO = getPageObject()

    if (currentPO.text === '') return
    liveSaving = true
    e2UpdateSubmittability()
    if (currentPO.title === '') {
      var x
      var generatedTitle = currentPO.text
      if ((x = generatedTitle.indexOf('.')) >= 0) generatedTitle = generatedTitle.substr(0, x)
      if ((x = generatedTitle.indexOf(';')) >= 0) generatedTitle = generatedTitle.substr(0, x)
      if ((x = generatedTitle.indexOf(',')) >= 0) generatedTitle = generatedTitle.substr(0, x)
      if ((x = generatedTitle.indexOf(')')) >= 0) generatedTitle = generatedTitle.substr(0, x)
      if (generatedTitle.indexOf('((') === 0) generatedTitle = generatedTitle.substr(2)
      generatedTitle = generatedTitle.substr(0, 1).toUpperCase() + generatedTitle.substr(1)
      $('#title').val(generatedTitle).change()
    }
    $('#livesave-button, #livesave-button + .e2-unsaved-led, #livesave-error').hide()
    $('#livesaving').fadeIn(333)
    e2SpinningAnimationStartStop($('#livesaving'), 1)

    e2AjaxSave({
      onCreated: function () {
        initPO = currentPO
        if ($('#e2-drafts') && $('#e2-drafts-item')) {
          $('#e2-drafts-item').fadeIn(333)
          $('<div class="e2-admin-menu-item-frame"></div>').css({
            'position': 'absolute',
            'left': $('#e2-note-form-wrapper').offset().left,
            'top': $('#e2-note-form-wrapper').offset().top,
            'width': $('#e2-note-form-wrapper').width(),
            'height': $('#e2-note-form-wrapper').height()
          }).appendTo('body').animate({
            'left': $('#e2-drafts').offset().left - 10,
            'top': $('#e2-drafts').offset().top - 5,
            'width': $('#e2-drafts').width() + 20,
            'height': $('#e2-drafts').height() + 10
          }, 667).fadeTo(333, 0.667).fadeOut(333)
          $('#e2-drafts-count').html($('#e2-drafts-count').html() * 1 + 1)
        }
      },
      onSaved: function () {
        initPO = currentPO
      },
      onError: e2LiveSaveError,
      onAjaxSuccess: function () {
        e2SpinningAnimationStartStop($('#livesaving'), 0)
        $('#livesaving').fadeOut(333)
      },
      onAjaxError: e2LiveSaveError,
      onAjaxComplete: function () {
        liveSaving = false

        e2UpdateSubmittability()
      }
    })
  }

  $('#form-note').on('submit', function (e) {
    e.preventDefault()

    var currentPO = getPageObject()

    liveSaving = true
    e2UpdateSubmittability()
    $('#submit-keyboard-shortcut, #note-save-error').hide()
    e2SpinningAnimationStartStop($('#note-saving'), 1)
    $('#note-saving').show()

    e2AjaxSave({
      onCreated: goTo,
      onSaved: goTo,
      onError: handleError,
      onAjaxError: handleError,
      onAjaxComplete: function () {
        liveSaving = false
        e2UpdateSubmittability()
      }
    })

    function goTo (ajaxresult) {
      initPO = currentPO
      e2SpinningAnimationStartStop($('#note-saving'), 0)
      $('#note-saving').hide()
      $('#note-saved').fadeIn(333)
      window.location.href = ajaxresult['note-url']
    }

    function handleError (msg) {
      $('#form-note').trigger('ajaxError')
      e2SpinningAnimationStartStop($('#note-saving'), 0)
      $('#note-saving').hide()
      $('#submit-keyboard-shortcut').show()
      $('#note-save-error').show()
      $('#note-save-error').attr('title', msg)
    }
  })

  $('#title').bind('input', function () {
    $('#alias').attr('placeholder', '')
  })

  var changesEventsList = 'change input keyup keydown keypress mouseup mousedown cut copy paste blur'
  var changesListener = function () {
    if ($('#stamp').val()) {
      $('#stamp').toggleClass(
        'input-error',
        ($('#stamp').val().match(stampMask) === null)
      )
    }
    e2UpdateSubmittability()

    var newPO = getPageObject()
    edited = !comparePageObjects(prevPO, newPO)
    changed = initPO ? !comparePageObjects(initPO, newPO) : true

    var $livesaveButton = $('#livesave-button, #livesave-button + .e2-unsaved-led')
    if (edited && changed && (newPO.text !== '')) {
      edited = false
      $('#livesaving').hide()
      document.e2.localCopies.initLocalSaver()
      $livesaveButton.fadeIn(333)
      prevPO = Object.assign({}, newPO)
    } else if (!changed) {
      changed = false
      removeLocalCopy()
      $livesaveButton.fadeOut(333)
      prevPO = Object.assign({}, newPO)
    }

    var title = newPO.title.trim()
    var text = newPO.text.trim()
    var $images = $('#e2-uploaded-images .e2-uploaded-image-preview')

    if (!$images.length && !title && !text && $livesaveButton.is(':visible')) {
      $livesaveButton.fadeOut(333)
    }
  }
  $('#title').add('#tags').add('#text').add('#alias').add('#stamp').bind(changesEventsList, changesListener)

  $('#tags').on('liszt:ready', function () {
    $('#tags_chzn .search-field').bind(changesEventsList, changesListener)
  })

  $('#title').bind('keydown', function (e) {
    if (e.keyCode === 13) $('#text').focus()
  })

  $('#livesave-button').click(function () { e2LiveSave(); return false })

  if (detect.mac) {
    bindKeys('Cmd+S', e2LiveSave, { prevent: true })
  } else {
    bindKeys('Ctrl+S', e2LiveSave, { prevent: true })
  }

  // if there is no autofocus on #text, let's move focus to #title
  if (!$('#text').is(':focus')) {
    $('#title')
      .attr('autofocus', true)
      .focus()
      .val($('#title').val()) // for prevent text selection in Safari
  }

  e2UpdateSubmittability()

  function removeLocalCopy () {
    if (!isLocalStorageAvailable) return

    if (initNoteId) {
      // if it's a new draft, it has id === 'new' before saving
      document.e2.localCopies.remove(initNoteId)
    } else {
      // ..and id === Number after
      document.e2.localCopies.remove($('#note-id').val())
    }

    document.e2.localCopies.destroyLocalSaver()
  }

  // returns object with form fields values
  function getPageObject () {
    return {
      title: $('#title').val(),
      tags: ($('#tags').val() || []).join(),
      text: $('#text').val(),
      alias: $('#alias').val(),
      stamp: $('#stamp').val()
    }
  }

  // returns true if objects are equal; else false
  function comparePageObjects (prevPO, newPO) {
    // 'cause all values of POs are strings, we can use JSON comparison
    return JSON.stringify(prevPO) === JSON.stringify(newPO)
  }
})
