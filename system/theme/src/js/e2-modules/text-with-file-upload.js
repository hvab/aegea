import getTransitionEvent from '../lib/getTransitionEvent'
import e2SpinningAnimationStartStop from '../e2-modules/e2SpinningAnimationStartStop'
import e2ShowUploadProgressInArc from '../e2-modules/e2ShowUploadProgressInArc'
import e2CanUploadThisFile from './e2CanUploadThisFile'
import e2PastePic from './e2PastePic'
import e2UploadFile from './e2UploadFile'
import e2Delfiles from './e2Delfiles'

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

  var $uploadedImages = $('#e2-uploaded-images')
  var $uploadedImagesInstances = $uploadedImages.find('.e2-uploaded-image')

  var $uploadControls = $('.e2-upload-controls')
  var $uploadButtonWrapper = $uploadControls.find('.e2-upload-controls-attach')
  var $uploadButton = $uploadButtonWrapper.find('.e2-upload-controls-attach-input')
  var $uploadSpinner = $uploadControls.find('.e2-upload-controls-uploading')

  var uploadControlsHiddenModifier = 'e2-upload-controls_hidden'
  var uploadButtonWrapperHiddenModifier = 'e2-upload-controls-attach_hidden'
  var uploadSpinnerHiddenModifier = 'e2-upload-controls-uploading_hidden'

  function $e2AddPasteableImage (imageThumb, imageFull, imageFilesize, imageWidth, imageHeight) {
    var $newImage = $('#e2-uploaded-image-prototype').clone(true)
    var $innerGood = $newImage.find('.e2-uploaded-image-inner_good')
    var $innerGoodImg = $innerGood.find('img')
    var $innerBad = $newImage.find('.e2-uploaded-image-inner_bad')
    var $innerBadNoImage = $innerBad.find('.e2-uploaded-image-noimage')
    var $popupMenu = $newImage.find('.e2-popup-menu')

    $newImage
      .removeAttr('id')
      .attr('style', '')
      .data('file', imageFull)
      .css('width', '')

    $newImage.addClass('e2-uploaded-image_active')
    $popupMenu.find('.e2-image-popup-menu-filename').text(imageFull).attr('title', imageFull)

    if (imageWidth && imageHeight) { // picture is available on server
      $innerBad.remove()
      $innerGoodImg
        .attr('src', imageThumb + '?' + new Date().getTime())
        .attr('alt', imageFull)
        .attr('width', imageWidth)
        .attr('height', imageHeight)

      $popupMenu.find('.e2-image-popup-menu-filesize').text(imageFilesize)
    } else { // picture is not available on server
      $innerGood.remove()
      $innerBadNoImage.attr('data-src', imageThumb)

      $popupMenu
        .find('.e2-popup-menu-widget-item').filter(':not(.e2-popup-menu-widget-item_info):not(.e2-popup-menu-widget-item_remove)')
        .addClass('e2-popup-menu-widget-item_disabled')
    }

    $(document).trigger('E2_ADMIN_ITEM_WITH_POPUP_MENU_INIT', {
      $popupMenu: $popupMenu
    })

    if ($.inArray(imageFull, listedThumbnails) === -1) {
     listedThumbnails.push(imageFull)
    }

    return $newImage
  }

  function e2DoneUploadingThisFileWithResponse (file, response, isDroppedIntoText) {
    response = JSON.parse(response)

    if (response['success']) {
      completedUploadSize += file.size

      var $thumbToUpdate = $(
        '#e2-uploaded-images img[src="' + response['thumb'] + '"], ' +
        '#e2-uploaded-images img[src^="' + response['thumb'] + '?"], ' +
        '#e2-uploaded-images .e2-uploaded-image-noimage[data-src="' + response['thumb'] + '"], ' +
        '#e2-uploaded-images .e2-uploaded-image-noimage[data-src^="' + response['thumb'] + '?"]'
      )
      var $thumbToUpdateParent = $thumbToUpdate.parents('.e2-uploaded-image')

      if (response['overwrite']) {
        e2SpinningAnimationStartStop($uploadSpinner, 0)
        $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
        $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)

        if ($thumbToUpdate.length) {
          $e2AddPasteableImage(
            response['thumb'], response['new-name'], response['filesize'], response['width'], response['height']
          ).insertAfter($thumbToUpdateParent)
          $thumbToUpdateParent.remove()
        }
      } else {
        if (isDroppedIntoText) e2PastePic(response['new-name'])

        var alreadyListed = ($.inArray(response['new-name'], listedThumbnails) !== -1)

        if (!alreadyListed) {
          $e2AddPasteableImage(
            response['thumb'], response['new-name'], response['filesize'], response['width'], response['height']
          ).appendTo($uploadedImages).show(333, function () {
            e2SpinningAnimationStartStop($uploadSpinner, 0)
            $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
            $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)
          })
        } else {
          e2SpinningAnimationStartStop($uploadSpinner, 0)
          $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
          $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)

          if ($thumbToUpdate.length) {
            $e2AddPasteableImage(
              response['thumb'], response['new-name'], response['filesize'], response['width'], response['height']
            ).insertAfter($thumbToUpdateParent)
            $thumbToUpdateParent.remove()
          }
        }
      }
    } else {
      e2SpinningAnimationStartStop($uploadSpinner, 0)
      $uploadSpinner.addClass(uploadSpinnerHiddenModifier)
      $uploadButtonWrapper.removeClass(uploadButtonWrapperHiddenModifier)

      if (response['error'] === 'could-not-create-thumbnail') {
        $('#e2-upload-error-cannot-create-thumbnail').slideDown(333)
      } else {
        $('#e2-upload-error-cannot-upload').slideDown(333)
      }
    }

    e2ClearUploadBuffer()
  }

  function e2ClearUploadBuffer () {
    if (filesToUpload.length) {
      var progressNode = $uploadSpinner.find('circle.e2-progress')[0]
      var file = filesToUpload.shift()
      var filename = file.name
      var url = $('#e2-file-upload-action').attr('href') + '?'

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

      $('.e2-upload-error').slideUp(333)

      var canUploadThisFile = e2CanUploadThisFile(filename)

      if (canUploadThisFile) {
        e2ShowUploadProgressInArc(progressNode, 0)
        e2SpinningAnimationStartStop($uploadSpinner, 1)
        $uploadSpinner.removeClass(uploadSpinnerHiddenModifier)
        $uploadButtonWrapper.addClass(uploadButtonWrapperHiddenModifier)

        e2UploadFile(
          file,
          url,
          function (e) {
            if (e.lengthComputable) {
              var progressPercent = (completedUploadSize + e.loaded) / totalUploadSize
              e2ShowUploadProgressInArc(progressNode, progressPercent)
            }
          },
          function (data, textStatus, jqHXR) {
            e2DoneUploadingThisFileWithResponse(file, data, file.e2DroppedIntoTextarea)
            e2ShowUploadProgressInArc(progressNode, 0)
          },
          function (jqXHR, textStatus, errorThrown) {
            e2DoneUploadingThisFileWithResponse(file, '{"success": false, "error": "' + textStatus + '"}', file.e2DroppedIntoTextarea)
            e2ShowUploadProgressInArc(progressNode, 0)
          }
        )
      } else {
        $('#e2-upload-error-unsupported-file').slideDown(333)
      }

      return false
    } else {
      totalUploadSize = 0
      completedUploadSize = 0

      return true
    }
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
      completedUploadSize = 0
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
      completedUploadSize = 0
      totalUploadSize += e.target.files[i].size
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

      var imageThumb
      var imageFull
      var imageFilesize
      var imageWidth
      var imageHeight

      if ($img.length) {
        imageThumb = $img.attr('src')
        imageFull = $img.data('filename')
        imageFilesize = $img.data('filesize')
        imageWidth = $img.attr('width')
        imageHeight = $img.attr('height')
      } else {
        imageThumb = $noimage.data('src')
        imageFull = $noimage.data('filename')
      }

      imagesArray.push($e2AddPasteableImage(imageThumb, imageFull, imageFilesize, imageWidth, imageHeight))
    })

    return imagesArray
  }

  $uploadedImages
    .on('click', '[data-e2-js-action*="remove-image"]', function (event) {
      var $picToDelete = $(event.currentTarget).parents('.e2-uploaded-image')
      var picToDeleteFile = $picToDelete.data('file')

      var picToDeleteDeletingModifier = 'e2-uploaded-image_deleting'
      var picToDeleteDeletedModifier = 'e2-uploaded-image_deleted'

      $picToDelete.addClass(picToDeleteDeletingModifier)

      e2Delfiles(picToDeleteFile)
        .done(function (msg) {
          if (msg.substr(0, 6) === 'error|') {
            $picToDelete.removeClass(picToDeleteDeletingModifier)
          } else {
            listedThumbnails.splice($.inArray(picToDeleteFile, listedThumbnails), 1)
            if (transitionEvent) {
              $picToDelete.off(transitionEvent + '.e2Delfiles').on(transitionEvent + '.e2Delfiles', function () {
                $picToDelete.remove()
              })
              $picToDelete.addClass(picToDeleteDeletedModifier)
            } else {
              $picToDelete.remove()
            }
          }
        })
        .fail(function () {
          $picToDelete.removeClass(picToDeleteDeletingModifier)
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
  }

  $uploadControls.removeClass(uploadControlsHiddenModifier)
  $uploadButton.on('change', e2LoadImagesFromInput)

  $('.e2-external-drop-target-body, .e2-external-drop-target-textarea').on('drop', e2LoadImagesFromDrop)
}

export default initTextWithFileUpload
