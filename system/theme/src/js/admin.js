import { isLocalStorageAvailable } from './lib/local-storage'
import e2SpinningAnimationStartStop from './lib/e2SpinningAnimationStartStop'

import './local-copies'
import './form-note-local-copy'
import './notes'
import './form-note'
import './text-with-file-upload'
import './form-note-publish'
import './form-preferences'
import './form-tag'

$('.e2-favourite-toggle').click(function () {
  const $this = $(this)
  const toggleFn = method => href => {
    $this
      .attr('href', href)
      .closest('.e2-note')[method]('e2-note-favourite')
  }

  return toggleClick($this, toggleFn('addClass'), toggleFn('removeClass'))
})

$('.e2-pinned-toggle').click(function () {
  const $this = $(this)
  const toggleFn = href => $this.attr('href', href)

  return toggleClick($this, toggleFn, toggleFn)
})

$('.e2-important-toggle').click(function () {
  const $this = $(this)
  const toggleFn = method => href => {
    $this
      .attr('href', href)
      .closest('.e2-comment, .e2-comment-form-meta-area')
      .find('.e2-comment-piece-markable')[method]('e2-comment-piece-marked')
  }

  return toggleClick($this, toggleFn('addClass'), toggleFn('removeClass'))
})

$('.e2-removed-toggle').click(function () {
  const $this = $(this)
  const $comment = $this.closest('.e2-comment')

  $comment
    .find('.e2-comment-actions, .e2-comment-actions-removed')
    .addClass('e2-comment-actions-disabled')

  return toggleClick(
    $this,
    href => {
      $comment
        .find('.e2-comment-actions')
        .removeClass('e2-comment-actions-disabled')
        .end()

        .find('.e2-comment-actions-removed')
        .hide()
        .end()

        .find('.e2-comment-content, .e2-comment-meta')
        .slideDown(333)
        .end()

        .find('.e2-comment-author')
        .removeClass('e2-comment-author-removed')
        .end()

        // TODO: it looks like we need to set right url just one time (in tmpl)
        .find('.e2-removed-toggle')
        .attr('href', href)

      if (!$comment.is('.e2-reply')) {
        $comment
          .siblings('.e2-reply')
          .slideDown(333)
      }
    },
    href => {
      $comment
        .find('.e2-comment-actions-removed')
        .removeClass('e2-comment-actions-disabled')
        .end()

        .find('.e2-comment-author')
        .addClass('e2-comment-author-removed')
        .end()

        .find('.e2-comment-meta, .e2-comment-content')
        .slideUp(333, () => $comment.find('.e2-comment-actions-removed').show())
        .end()

        .find('.e2-removed-toggle')
        .attr('href', href)

      if (!$comment.is('.e2-reply')) {
        $comment
          .siblings('.e2-reply')
          .slideUp(333)
      }
    }
  )
})

$('.e2-external-drop-target')
  .bind('dragover dragenter', dragEnter)
  .bind('dragleave drop', dragLeave)

$('.e2-user-picture-container').bind('drop', dropUserPic)

initLocalCopyIndicators()

function uploadFile ({ file, url, progressCallback, doneCallback, errorCallback }) {
  if (window.FormData) {
    const data = new window.FormData()
    data.append('file', file)

    $.ajax({
      type: 'POST',
      timeout: 0,
      url,
      data,
      cache: false,
      contentType: false,
      processData: false,
      xhr () {
        const myXhr = $.ajaxSettings.xhr()
        if (myXhr.upload) {
          myXhr.upload.addEventListener('progress', progressCallback, false)
        }
        return myXhr
      },
      success: doneCallback,
      error: errorCallback
    })
  }
}

function toggleClick ($this, functionOn, functionOff) {
  $this.removeClass('e2-toggle-on')
  $this.addClass('e2-toggle-thinking')

  e2SpinningAnimationStartStop($this, 1)

  $.ajax({
    type: 'post',
    timeout: 10000,
    url: $this.attr('href'),
    data: 'result=ajaxresult',
    success (msg) {
      if (msg.substr(0, 10) === 'on-rehref|') {
        $this.addClass('e2-toggle-on')
        functionOn(msg.substr(10))
      }
      if (msg.substr(0, 11) === 'off-rehref|') {
        $this.removeClass('e2-toggle-on')
        functionOff(msg.substr(11))
      }
    },
    error () {
      window.location.href = $this.attr('href')
    },
    complete () {
      $this.removeClass('e2-toggle-thinking')
      e2SpinningAnimationStartStop($this, 0)
    }
  })

  return false
}

function dragEnter (e) {
  const dt = e.originalEvent.dataTransfer
  if (!dt) return

  // FF
  if (dt.types.contains && !dt.types.contains('Files')) return

  // Chrome
  if (dt.types.indexOf && dt.types.indexOf('Files') === -1) return
  if (dt.dropEffect) dt.dropEffect = 'copy'

  const $this = $(this)

  $this.addClass('e2-external-drop-target-dragover')
  if ($this.hasClass('e2-external-drop-target-altable') && e.altKey) {
    $this.addClass('e2-external-drop-target-dragover-alt')
  } else {
    $this.removeClass('e2-external-drop-target-dragover-alt')
  }

  return false
}

function dragLeave () {
  const $this = $(this)

  $this.removeClass('e2-external-drop-target-dragover')
  $this.removeClass('e2-external-drop-target-dragover-alt')

  return false
}

function showUploadProgressInArc (arc, progress) {
  const fakeProgress = 0.1 + Math.min(progress, 1) * 0.8
  const maxDash = 245

  arc.style.strokeDashoffset = Math.floor(maxDash - fakeProgress * maxDash)
}

function dropUserPic (e) {
  const $this = $(this)
  const $pic = $this.find('img')
  const dt = e.originalEvent.dataTransfer
  if (!dt && !dt.files) return

  if (dt.files.length === 1) {
    const file = dt.files[0]
    const progressNode = $('#e2-user-picture-uploading #e2-progress')[0] // TODO: two ids in selector? why?
    const uploadingClass = 'e2-user-picture-container-uploading'

    e2SpinningAnimationStartStop($this, 1)

    $this.addClass(uploadingClass)

    uploadFile({
      file,
      url: $('#e2-userpic-upload-action').attr('href'),
      progressCallback (e) { showUploadProgressInArc(progressNode, e.loaded / e.total) },
      doneCallback (data) {
        showUploadProgressInArc(progressNode, 0)
        e2SpinningAnimationStartStop($this, 0)

        if (data.substr(0, 6) === 'image|') {
          const image = data.substr(6).split('|')[0]
          $pic.attr('src', image + '?' + encodeURIComponent(new Date()))
          $pic.bind('load', () => $this.removeClass(uploadingClass))
          $('.e2-set-userpic-by-dragging').slideUp(333)
        } else {
          $this.removeClass(uploadingClass)
        }
      },
      errorCallback () { showUploadProgressInArc(progressNode, 0) }
    })
  }

  return false
}

function initLocalCopyIndicators () {
  if (isLocalStorageAvailable) {
    const $draftsLink = $('#e2-drafts-item')
    const $draftsUnsavedLed = $draftsLink.find('.e2-unsaved-led')
    const $newNoteUnsavedLed = $('#e2-new-note-item .e2-unsaved-led')
    const $notesUnsaved = $('#e2-notes-unsaved')
    const $nothingMessage = $('#e2-nothing-message')
    const $formNote = $('#form-note')

    const localCopiesList = document.e2.localCopies.getList()
    const isNewLocalCopyAvailable = document.e2.localCopies.doesCopyExist('new')
    const noteId = $formNote ? $('#note-id').val() : null
    const isNoteLocalCopyAvailable = noteId !== 'new' ? document.e2.localCopies.doesCopyExist(noteId) : false

    let localCopiesCount = Object.keys(localCopiesList).length

    if (isNewLocalCopyAvailable) localCopiesCount--
    if (isNoteLocalCopyAvailable) localCopiesCount--

    // indicator near the drafts button
    if ($draftsUnsavedLed && localCopiesCount > 0) {
      $draftsLink.show()
      $draftsUnsavedLed.show()
    }

    // indicator near the new note button
    if ($newNoteUnsavedLed && isNewLocalCopyAvailable) {
      $newNoteUnsavedLed.show()
    }

    // indicators on the drafts page
    if ($notesUnsaved && $nothingMessage) {
      const newName = document.e2.localCopies.getName('new')

      if (localCopiesList.hasOwnProperty(newName)) {
        delete localCopiesList[newName]
      }

      // show indicators near the drafts if they have local copies
      for (let key in localCopiesList) {
        if (localCopiesList[key].isPublished === 'false') {
          $('#e2-draft-' + key + ' .e2-unsaved-led').show()
          delete localCopiesList[key]
        }
      }

      if (Object.keys(localCopiesList).length) {
        for (let lc in localCopiesList) {
          const copy = document.e2.localCopies.get(lc)

          if (!copy) continue // if smth goes wrong we just get out of here

          const $link = $('#e2-unsaved-note-prototype').clone(true)
          $link.attr('id', null)
          $('.e2-admin-link', $link).attr('href', copy.link)
          $('u', $link).html(copy.title)
          $link.attr('style', '')

          $notesUnsaved.append($link)
        }

        $notesUnsaved.show()
        $nothingMessage.hide()
      }
    }
  }
}
