import getTransitionEvent from '../lib/getTransitionEvent'
import e2SpinningAnimationStartStop from '../e2-modules/e2SpinningAnimationStartStop'
import e2ShowUploadProgressInArc from '../e2-modules/e2ShowUploadProgressInArc'
import e2ParseAcceptExtensions from './e2ParseAcceptExtensions'
import e2PastePic from './e2PastePic'
import e2UploadFile from './e2UploadFile'
import e2DeleteFile from './e2DeleteFile'
import e2RenameFile from './e2RenameFile'
import e2NiceError from './e2NiceError'

function initTextWithFileUpload () {
  if (!$('#form-tag').length && !$('#form-note').length) return

  if ($('.e2-upload-controls-attach').length > 0) {
    $(document.body).addClass(
      'e2-external-drop-target e2-external-drop-target-body e2-external-drop-target-altable'
    )
  }

  var transitionEvent = getTransitionEvent()

  var filesToUpload = []
  var listedThumbnails = []

  var completedUploadSize = 0
  var totalUploadSize = 0

  var $uploadedImages = $('.e2-uploaded-images')
  var $uploadedImagesInstances = $uploadedImages.find('.e2-uploaded-image')

  var $uploadControls = $('.e2-upload-controls')
  var $uploadButtonWrapper = $uploadControls.find('.e2-upload-controls-attach')
  var $uploadButton = $uploadButtonWrapper.find('.e2-upload-controls-attach-input')
  var $uploadSpinner = $uploadControls.find('.e2-upload-controls-uploading')

  var uploadAcceptAttr = $uploadButton.attr('accept')
  var uploadSupportedMessage = $uploadButton.data('e2SupportedMessage')
  var uploadAccept = e2ParseAcceptExtensions(uploadAcceptAttr)

  var uploadControlsHiddenModifier = 'e2-upload-controls_hidden'
  var uploadButtonWrapperHiddenModifier = 'e2-upload-controls-attach_hidden'
  var uploadSpinnerHiddenModifier = 'e2-upload-controls-uploading_hidden'
  var uploadedImageHighlightedModifier = 'e2-uploaded-image_highlighted'
  var uploadedImageDeletingModifier = 'e2-uploaded-image_deleting'
  var uploadedImageDeletedModifier = 'e2-uploaded-image_deleted'
  var $text = $('#text')

  // keep upload highlighting derived from the current selection so the upload
  // list always reflects whichever filename directives are covered by it
  // checks whether a line starts with a given filename and only allows
  // whitespace after it, matching the editor’s filename-directive syntax
  function e2LineStartsWithFilename (line, filename) {
    if (!filename || line.indexOf(filename) !== 0) return false

    var nextChar = line.charAt(filename.length)
    return nextChar === '' || /\s/.test(nextChar)
  }

  // returns every text line touched by the current selection, but only while
  // the editor textarea is focused because highlight must disappear on blur
  function e2GetCurrentTextLines () {
    if (!$text.length || document.activeElement !== $text[0]) return ''

    var field = $text[0]
    var lineStart = field.selectionStart
    var lineEnd = field.selectionEnd

    while (
      lineStart > 0 &&
      field.value.charAt(lineStart - 1) !== '\n' &&
      field.value.charAt(lineStart - 1) !== '\r'
    ) {
      lineStart -= 1
    }

    while (
      lineEnd < field.value.length &&
      field.value.charAt(lineEnd) !== '\n' &&
      field.value.charAt(lineEnd) !== '\r'
    ) {
      lineEnd += 1
    }

    return field.value.substring(lineStart, lineEnd).split(/\r\n|\r|\n/)
  }

  // collects upload filenames still present in the list
  // and skips items that are already being deleted
  // or are waiting for removal animation to finish
  function e2GetUploadedFilenames () {
    return $uploadedImages.find('.e2-uploaded-image').map(function () {
      var $this = $(this)
      if ($this.hasClass(uploadedImageDeletingModifier) || $this.hasClass(uploadedImageDeletedModifier)) return null
      return $this.data('file')
    }).get().filter(Boolean).sort(function (a, b) {
      return b.length - a.length
    })
  }

  // finds every uploaded filename referenced by the current selection.
  // longer filenames go first so shared prefixes do not match too early
  function e2GetHighlightedFilenames () {
    var currentLines = e2GetCurrentTextLines()
    var uploadedFilenames = e2GetUploadedFilenames()
    var highlightedFilenames = []

    if (!currentLines.length) return highlightedFilenames

    for (var i = 0; i < uploadedFilenames.length; i++) {
      for (var j = 0; j < currentLines.length; j++) {
        if (e2LineStartsWithFilename(currentLines[j], uploadedFilenames[i])) {
          highlightedFilenames.push(uploadedFilenames[i])
          break
        }
      }
    }

    return highlightedFilenames
  }

  // removes the visual highlight from every upload item
  function e2ClearHighlightedUpload () {
    $uploadedImages.find('.' + uploadedImageHighlightedModifier).removeClass(uploadedImageHighlightedModifier)
  }

  // recomputes which uploads should be highlighted from the current selection
  // and applies the visual state to matching upload items in the list
  function e2UpdateHighlightedUpload () {
    var highlightedFilenames = e2GetHighlightedFilenames()

    e2ClearHighlightedUpload()
    if (!highlightedFilenames.length) return

    $uploadedImages.find('.e2-uploaded-image').each(function () {
      var $this = $(this)
      if ($.inArray($this.data('file'), highlightedFilenames) !== -1) {
        $this.addClass(uploadedImageHighlightedModifier)
      }
    })
  }

  function initJouelePlayers ($context, forceReinit) {
    if (!$context || !$context.length) return
    if (typeof $.fn === 'undefined' || typeof $.fn.jouele !== 'function') return

    $context.find('.e2-upload-jouele-target').each(function () {
      var $control = $(this)
      if (!$control.attr('data-href')) return

      if (forceReinit && $control.data('jouele')) {
        try {
          $control.jouele('destroy')
        } catch (e) {}
        $control.removeData('jouele')
      }

      if (!$control.data('jouele')) {
        $control.jouele()
      }
    })
  }

  function $e2AddPasteableUpload (uploadThumb, uploadFilename, uploadFilesize, uploadWidth, uploadHeight, uploadOriginalHref, uploadIsAudio) {
    var $newImage = $('#e2-uploaded-image-prototype').clone(true)
    var $innerGood = $newImage.find('.e2-uploaded-image-inner_good')
    var $innerGoodImg = $innerGood.find('img')
    var $innerBad = $newImage.find('.e2-uploaded-image-inner_bad')
    var $innerBadNoImage = $innerBad.find('.e2-uploaded-image-noimage')
    var $popupMenu = $newImage.find('.e2-popup-menu')
    var $audioRow = $popupMenu.find('.e2-image-popup-menu-audio')
    var $audioIcon = $popupMenu.find('.e2-popup-menu-widget-item-icon_audio')
    var $audioControls = $popupMenu.find('.e2-upload-jouele-target')

    $newImage
      .removeAttr('id')
      .attr('style', '')
      .data('file', uploadFilename)
      .data('audioHref', uploadOriginalHref || '')
      .data('isAudio', !!uploadIsAudio)
      .css('width', '')

    $popupMenu.find('.e2-image-popup-menu-filename').text(uploadFilename).attr('title', uploadFilename)
    if (uploadIsAudio && uploadOriginalHref) {
      $audioRow.show()
      $audioIcon.show()
      $audioControls.attr('data-href', uploadOriginalHref)
    } else {
      $audioRow.hide()
      $audioIcon.hide()
      $audioControls.attr('data-href', '')
    }

    if (uploadWidth && uploadHeight) { // picture is available on server
      $innerBad.remove()
      $innerGoodImg
        .attr('src', uploadThumb + '?' + new Date().getTime())
        // .attr('alt', uploadFilename) // will need to change on rename if used
        .attr('width', uploadWidth)
        .attr('height', uploadHeight)

      $popupMenu.find('.e2-image-popup-menu-filesize').text(uploadFilesize)
    } else { // picture is not available on server
      $newImage.addClass('e2-uploaded-image_broken')
      $innerGood.remove()
      $innerBadNoImage.attr('data-src', uploadThumb)

      $popupMenu
        .find('.e2-popup-menu-widget-item').filter(':not(.e2-popup-menu-widget-item_info):not(.e2-popup-menu-widget-item_remove)')
        .addClass('e2-popup-menu-widget-item_disabled')
    }

    $(document).trigger('E2_ADMIN_ITEM_WITH_POPUP_MENU_INIT', {
      $popupMenu: $popupMenu
    })

    if ($.inArray(uploadFilename, listedThumbnails) === -1) {
     listedThumbnails.push(uploadFilename)
    }

    return $newImage
  }

  function e2ClearUploadBuffer () {
    while (filesToUpload.length) {
      var $progress = $uploadSpinner.find('circle.e2-progress')
      var file = filesToUpload.shift()
      var url = $('#e2-file-upload-action').attr('href')

      if (url.indexOf('?go=') == -1) {
        url += '?'
      } else {
        url += '&'
      }

      if (uploadAccept && !uploadAccept.allows(file.name)) {
        e2NiceError({
          message: uploadSupportedMessage,
          debug: {
            data: {
              file: file
            }
          }
        })
        if (!filesToUpload.length) {
          // stop spinner if previous uploads left it spinning
          e2SpinningAnimationStartStop($uploadSpinner, 0)
          $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
          $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
        }
        continue
      }

      if (typeof $('#note-id').val() !== 'undefined') {
        url += 'entity=note&entity-id=' + $('#note-id').val()
      } else if (typeof $('#tag-id').val() !== 'undefined') {
        url += 'entity=tag&entity-id=' + $('#tag-id').val()
      } else {
        url = null
      }
      if (url && file.e2AltKeyPressed) {
        url += '&overwrite'
      }

      // console.log(url)

      e2SpinningAnimationStartStop($uploadSpinner, 1)

      $uploadSpinner.removeClass(uploadSpinnerHiddenModifier)
      $uploadButtonWrapper.addClass(uploadButtonWrapperHiddenModifier)

      e2UploadFile({
        file: file,
        url: url,
        progress: function (event) {
          if (event.lengthComputable) {
            e2ShowUploadProgressInArc($progress, (completedUploadSize + event.loaded) / totalUploadSize)
          }
        },
        success: function (response) {
          completedUploadSize += file.size

          var $thumbToUpdate = $(
            '#e2-uploaded-images img[src="' + response['data']['thumb'] + '"], ' +
            '#e2-uploaded-images img[src^="' + response['data']['thumb'] + '?"], ' +
            '#e2-uploaded-images .e2-uploaded-image-noimage[data-src="' + response['data']['thumb'] + '"], ' +
            '#e2-uploaded-images .e2-uploaded-image-noimage[data-src^="' + response['data']['thumb'] + '?"]'
          )
          var $thumbToUpdateParent = $thumbToUpdate.parents('.e2-uploaded-image')

          if (response['data']['overwrite']) {
            if (!filesToUpload.length) {
              e2SpinningAnimationStartStop($uploadSpinner, 0)
              $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
              $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
            }

            if ($thumbToUpdate.length) {
              var $insertedOverwrite = $e2AddPasteableUpload(
                response['data']['thumb'],
                response['data']['new-name'],
                response['data']['filesize'],
                response['data']['width'],
                response['data']['height'],
                response['data']['original-href'],
                response['data']['is-audio?']
              ).insertAfter($thumbToUpdateParent)
              initJouelePlayers($insertedOverwrite, false)
              $thumbToUpdateParent.remove()
              e2UpdateHighlightedUpload()
            }
          } else {
            if (file.e2DroppedIntoTextarea) e2PastePic(response['data']['new-name'])

            var alreadyListed = ($.inArray(response['data']['new-name'], listedThumbnails) !== -1)

            if (!alreadyListed) {
              var $newlyAppended = $e2AddPasteableUpload(
                response['data']['thumb'],
                response['data']['new-name'],
                response['data']['filesize'],
                response['data']['width'],
                response['data']['height'],
                response['data']['original-href'],
                response['data']['is-audio?']
              ).appendTo($uploadedImages)
              initJouelePlayers($newlyAppended, false)
              $newlyAppended.show(200, function () {
                e2UpdateHighlightedUpload()
                if (!filesToUpload.length) {
                  e2SpinningAnimationStartStop($uploadSpinner, 0)
                  $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
                  $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
                }
              })
            } else {
              if (!filesToUpload.length) {
                e2SpinningAnimationStartStop($uploadSpinner, 0)
                $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
                $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
              }
              if ($thumbToUpdate.length) {
                var $insertedDuplicate = $e2AddPasteableUpload(
                  response['data']['thumb'],
                  response['data']['new-name'],
                  response['data']['filesize'],
                  response['data']['width'],
                  response['data']['height'],
                  response['data']['original-href'],
                  response['data']['is-audio?']
                ).insertAfter($thumbToUpdateParent)
                initJouelePlayers($insertedDuplicate, false)
                $thumbToUpdateParent.remove()
                e2UpdateHighlightedUpload()
              }
            }
          }

          e2ClearUploadBuffer()
        },
        error: function () {
          if (!filesToUpload.length) {
            e2SpinningAnimationStartStop($uploadSpinner, 0)
            $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
            $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
          }

          e2ClearUploadBuffer()
        },
        complete: function() {
          e2ShowUploadProgressInArc($progress, 0)
        }
      })

      return false
    }

    totalUploadSize = 0
    completedUploadSize = 0

    return true
  }

  function e2LoadImagesFromDrop (e) {
    var dt = e.originalEvent.dataTransfer
    if (!dt || !dt.files) return

    var e2DroppedIntoTextarea = $(e.target).attr('id') === 'text'

    filesToUpload.length = 0

    for (var i = 0; i < dt.files.length; i++) {
      dt.files[i].e2AltKeyPressed = e.altKey
      dt.files[i].e2DroppedIntoTextarea = e2DroppedIntoTextarea
      filesToUpload.push(dt.files[i])
      // completedUploadSize = 0
      totalUploadSize += dt.files[i].size
    }

    e2ClearUploadBuffer()

    return false
  }

  function e2LoadImagesFromInput (e) {
    if (!e.target.files.length) return false

    filesToUpload.length = 0

    for (var i = 0; i < e.target.files.length; i++) {
      filesToUpload.push(e.target.files[i])
      // completedUploadSize = 0
      totalUploadSize += e.target.files[i].size
    }

    e2ClearUploadBuffer()

    return false
  }

  function e2MakeImageFilename (now) {
    var month = now.getMonth()
    month = month < 10 ? '0'+month : month;
    var day = now.getDate()
    day = day < 10 ? '0'+day : day;
    var hours = now.getHours()
    hours = hours < 10 ? '0'+hours : hours;
    var minutes = now.getMinutes()
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var seconds = now.getSeconds()
    seconds = seconds < 10 ? '0'+seconds : seconds;
    return (
      'image-' + now.getFullYear() + month + day +
      '-' + hours + minutes + seconds +
      '.png'
    )
  }

  function e2LoadImagesFromPaste (e) {
    const files = ((e.clipboardData || e.originalEvent.clipboardData).files || []);
    
    if (!files.length) return;

    filesToUpload.length = 0
    
    for (let i = 0; i < files.length; i++) {
      var e2File = files[i]
      var now = new Date()

      if ((e2File.lastModified === now.getTime()) && (e2File.name === 'image.png')) {
        // must be an image pasted directly from clipboard, not a file with a name
        // e2File = new File ([files[i]], e2MakeImageFilename (now), {
        e2File = new File ([files[i]], $uploadControls.data('e2FilenamePrefix') + '.png', {
          lastModified: files[i].lastModified,
          size: files[i].size,
          type: files[i].type,
          webkitRelativePath: files[i].webkitRelativePath,
        })
      }

      // set e2DroppedIntoTextarea to true to “emulate” dropping 
      // for auto pasting filename into the text field
      e2File.e2DroppedIntoTextarea = true

      filesToUpload.push(e2File)
      // completedUploadSize = 0
      totalUploadSize += e2File.size
    }

    e2ClearUploadBuffer()

    return false
  }

  function e2ChangeImagesToPasteableImages () {
    var imagesArray = []

    $uploadedImagesInstances.each(function () {
      var $this = $(this)
      var $img = $this.find('img')
      var $noimage = $this.find('.e2-uploaded-image-noimage')

      var uploadThumb
      var uploadFilename
      var uploadFilesize
      var uploadWidth
      var uploadHeight
      var uploadOriginalHref
      var uploadIsAudio

      if ($img.length) {
        uploadThumb = $img.attr('src')
        uploadFilename = $img.data('filename')
        uploadFilesize = $img.data('filesize')
        uploadWidth = $img.attr('width')
        uploadHeight = $img.attr('height')
        uploadOriginalHref = $img.data('href')
        uploadIsAudio = !!$img.data('isAudio')
      } else {
        uploadThumb = $noimage.data('src')
        uploadFilename = $noimage.data('filename')
        uploadOriginalHref = $noimage.data('href')
        uploadIsAudio = !!$noimage.data('isAudio')
      }

      imagesArray.push($e2AddPasteableUpload(
        uploadThumb,
        uploadFilename,
        uploadFilesize,
        uploadWidth,
        uploadHeight,
        uploadOriginalHref,
        uploadIsAudio
      ))
    })

    return imagesArray
  }

  $uploadedImages
    .on('click', '[data-e2-js-action*="rename-image"]', function (event) {
      var $this = $(event.currentTarget)
      var $whatToRename = $this.parents('.e2-uploaded-image')
      var $mySpinner = $whatToRename.find('#e2-spinner-renaming')
      var picToRenameFile = $whatToRename.data('file')
      var newName = prompt('', picToRenameFile)
      if (newName === null) return false
      newName = newName.trim ()
      if (newName === '') return false
      if (picToRenameFile === newName) return false

      // var $progress = $uploadSpinner.find('circle.e2-progress')
      // e2ShowUploadProgressInArc($progress, 50, true)
      $mySpinner.fadeIn(200)
      e2SpinningAnimationStartStop($mySpinner, 1)

      e2RenameFile({
        file: picToRenameFile,
        newName: newName,
        success: function (response) {
          var uploadFilename = response['data']['new-name']

          // replace in popup menu
          $whatToRename.find('.e2-image-popup-menu-filename').text(uploadFilename).attr('title', uploadFilename)
          $whatToRename.data('file', uploadFilename)
          if ($whatToRename.data('isAudio')) {
            var newAudioHref = response['data']['original-href']
            var $audioRow = $whatToRename.find('.e2-image-popup-menu-audio')
            var $audioIcon = $whatToRename.find('.e2-popup-menu-widget-item-icon_audio')
            var $audioControls = $whatToRename.find('.e2-upload-jouele-target')
            if (newAudioHref) {
              $whatToRename.data('audioHref', newAudioHref)
              $audioControls.attr('data-href', newAudioHref)
              $audioRow.show()
              $audioIcon.show()
            }
            initJouelePlayers($whatToRename, true)
          }

          // replace in listedThumbnails
          var arrayIndex = listedThumbnails.indexOf(picToRenameFile)
          if (arrayIndex !== -1) {
              listedThumbnails[arrayIndex] = uploadFilename
          }

          // BUGBUG
          // while renaming to an existing file with the same content,
          // the files will merge. both original files could be in the
          // thumbnail list in front of me. so we have to merge them here!
          
          // Replace only filename directives at the beginning of a line so
          // the editor and upload highlighting keep following the same rule.
          var text = document.getElementById('text').value
          text = text.replace(/^.*$/gm, function (line) {
            if (!e2LineStartsWithFilename(line, picToRenameFile)) return line
            return uploadFilename + line.substring(picToRenameFile.length)
          })
          document.getElementById('text').value = text
          document.getElementById('text').dispatchEvent(new Event('input'))
          e2UpdateHighlightedUpload()
          
        },
        complete: function () {
          e2SpinningAnimationStartStop($mySpinner, 0)
          $mySpinner.hide()
        }
      })
      return false
    })
    .on('click', '[data-e2-js-action*="remove-image"]', function (event) {
      var $this = $(event.currentTarget)
      var $picToDelete = $this.parents('.e2-uploaded-image')
      var picToDeleteFile = $picToDelete.data('file')

      $picToDelete.addClass(uploadedImageDeletingModifier)

      e2DeleteFile({
        file: picToDeleteFile,
        success: function () {
          listedThumbnails.splice($.inArray(picToDeleteFile, listedThumbnails), 1)
          e2UpdateHighlightedUpload()

          if (transitionEvent) {
            $picToDelete.off(transitionEvent + '.e2DeleteFile').on(transitionEvent + '.e2DeleteFile', function () {
              $picToDelete.remove()
              e2UpdateHighlightedUpload()
            })
            $picToDelete.addClass(uploadedImageDeletedModifier)
          } else {
            $picToDelete.remove()
            e2UpdateHighlightedUpload()
          }
        },
        error: function () {
          $picToDelete.removeClass(uploadedImageDeletingModifier)
          e2UpdateHighlightedUpload()
        }
      })

      return false
    })
    .on('click', '[data-e2-js-action*="paste-image"]', function (event) {
      var $this = $(event.currentTarget)
      e2PastePic($this.parents('.e2-uploaded-image').data('file'))
      return false
    })

  if ($uploadedImagesInstances.length) {
    $uploadedImages.html(e2ChangeImagesToPasteableImages())
    initJouelePlayers($uploadedImages, false)
  }

  $text
    .on('focus click keyup input change mouseup select', e2UpdateHighlightedUpload)
    .on('blur', e2ClearHighlightedUpload)

  $uploadControls.removeClass(uploadControlsHiddenModifier)
  $uploadButton.on('change', e2LoadImagesFromInput)

  $('.e2-external-drop-target-body, .e2-external-drop-target-textarea')
    .on('drop', e2LoadImagesFromDrop)
    .on('paste', e2LoadImagesFromPaste)
}

export default initTextWithFileUpload
