import { isLocalStorageAvailable } from './lib/local-storage'
import initLocalCopies from './lib/local-copies'
import e2ShowUploadProgressInArc from './e2-modules/e2ShowUploadProgressInArc'
import e2SpinningAnimationStartStop from './e2-modules/e2SpinningAnimationStartStop'
import initNotes from './e2-modules/notes'
import initFormNoteLocalCopy from './e2-modules/form-note-local-copy'
import initFormNote from './e2-modules/form-note'
import initFormNotePublish from './e2-modules/form-note-publish'
import initFormPreferences from './e2-modules/form-preferences'
import initFormTag from './e2-modules/form-tag'
import e2UploadFile from './e2-modules/e2UploadFile'
import initTextWithFileUpload from './e2-modules/text-with-file-upload'

if (typeof $ !== 'undefined') {
  $(function () {
    /* First init modules */
    initLocalCopies()
    initFormNoteLocalCopy()
    initNotes()
    initFormNote()
    initTextWithFileUpload()
    initFormNotePublish()
    initFormPreferences()
    initFormTag()

    /* Second init obsolete functions */
    function initObsoleteFunction () {
      /* Drops */
      $('.e2-external-drop-target').on('dragover dragenter', dragEnter).on('dragleave drop', dragLeave)
      $('.e2-user-picture-container').on('drop', dropUserPic)

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

      function dropUserPic (e) {
        const $this = $(this)
        const $pic = $this.find('img')
        const dt = e.originalEvent.dataTransfer
        if (!dt && !dt.files) return

        if (dt.files.length === 1) {
          const file = dt.files[0]
          const progressNode = $('.e2-user-picture-uploading circle.e2-progress')[0]
          const uploadingClass = 'e2-user-picture-container-uploading'

          e2SpinningAnimationStartStop($this, 1)

          $this.addClass(uploadingClass)

          e2UploadFile(
            file,
            $('.e2-userpic-upload-action').attr('href'),
            function (e) {
              if (e.lengthComputable) {
                e2ShowUploadProgressInArc(progressNode, e.loaded / e.total)
              }
            },
            function (response, textStatus, jqHXR) {
              response = JSON.parse(response)
              e2ShowUploadProgressInArc(progressNode, 0)
              e2SpinningAnimationStartStop($this, 0)

              if (response['success']) {
                const image = response['data']['new-image-src']
                $pic.attr('src', image + '?' + encodeURIComponent(new Date()))
                $pic.on('load', () => $this.removeClass(uploadingClass))
                $('.e2-set-userpic-by-dragging').slideUp(333)
              } else {
                $this.removeClass(uploadingClass)
              }
            },
            function (jqXHR, textStatus, errorThrown) {
              e2ShowUploadProgressInArc(progressNode, 0)
            }
          )
        }

        return false
      }

      /* Local copy indicators */
      function initLocalCopyIndicators () {
        if (!isLocalStorageAvailable) return

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

      initLocalCopyIndicators()
    }

    initObsoleteFunction()

    /* Third init admin items and couple items */
    function initAllAdminItems () {
      var toggleThinkingStatus = function ($link, status) {
        if (status) {
          $link.addClass('e2-admin-item_thinking')
          e2SpinningAnimationStartStop($link, 1)
        } else {
          e2SpinningAnimationStartStop($link, 0)
          $link.removeClass('e2-admin-item_thinking')
        }
      }

      var toggleDisabledStatus = function ($link, status) {
        if (status) {
          $link.addClass('e2-admin-item_disabled e2-popup-menu-widget-item_disabled')
        } else {
          $link.removeClass('e2-admin-item_disabled e2-popup-menu-widget-item_disabled')
        }
      }

      var makeAjaxRequest = function ($link, functionWhenToggleOn, functionWhenToggleOff) {
        if ($link.hasClass('e2-admin-item_disabled')) return true
        if ($link.hasClass('e2-popup-menu-widget-item_disabled')) return true

        $link.removeClass('e2-admin-item_on')

        toggleThinkingStatus($link, 1)
        toggleDisabledStatus($link, 1)

        $.ajax({
          type: 'post',
          timeout: 10000,
          url: $link.attr('href'),
          data: 'result=ajaxresult',
          success: function (response) {
            response = JSON.parse(response)
            if (response['success']) {
              if (response['data']['flag-now-on']) {
                $link.addClass('e2-admin-item_on')
                functionWhenToggleOn(response['data']['new-href'], $link)
              } else {
                $link.removeClass('e2-admin-item_on')
                functionWhenToggleOff(response['data']['new-href'], $link)
              }
            }
          },
          error: function () {
            window.location.href = $link.attr('href')
          },
          complete: function () {
            toggleThinkingStatus($link, 0)
            toggleDisabledStatus($link, 0)
          }
        })
      }

      var onClick = function ($link) {
        var actionsVocabulary = {
          'toggle-favourite': function () {
            makeAjaxRequest(
              $link,
              function (href, $link) {
                $link.attr('href', href).parents('.e2-note').addClass('e2-note-favourite')
              },
              function (href, $link) {
                $link.attr('href', href).parents('.e2-note').removeClass('e2-note-favourite')
              }
            )
          },
          'toggle-pinned': function () {
            makeAjaxRequest(
              $link,
              function (href, $link) {
                $link.attr('href', href)
              },
              function (href, $link) {
                $link.attr('href', href)
              }
            )
          },
          'toggle-important': function () {
            makeAjaxRequest(
              $link,
              function (href, $link) {
                $link.attr('href', href).parents('.e2-comment, .e2-comment-form-meta-area').find('.e2-comment-piece-markable').addClass('e2-comment-piece-marked')
              },
              function (href, $link) {
                $link.attr('href', href).parents('.e2-comment, .e2-comment-form-meta-area').find('.e2-comment-piece-markable').removeClass('e2-comment-piece-marked')
              }
            )
          },
          'removed-href': function () {
            makeAjaxRequest(
              $link,
              function (href, $link) {
              },
              function (href, $link) {
                var $comment = $link.parents('.e2-comment')

                $comment.find('.e2-comment-author').addClass('e2-comment-author-removed')
                $comment.find('.e2-comment-meta, .e2-comment-content').slideUp(333)

                if (!$comment.hasClass('.e2-reply')) {
                  $comment.siblings('.e2-reply').slideUp(333)
                }

                $link.trigger('E2_ADMIN_COUPLE_CHANGE_ITEM', {response: 'removed'})
              }
            )
          },
          'replaced-href': function () {
            makeAjaxRequest(
              $link,
              function (href, $link) {
                var $comment = $link.parents('.e2-comment')

                $comment.find('.e2-comment-content, .e2-comment-meta').slideDown(333)
                $comment.find('.e2-comment-author').removeClass('e2-comment-author-removed')

                if (!$comment.hasClass('.e2-reply')) {
                  $comment.siblings('.e2-reply').slideDown(333)
                }

                $link.trigger('E2_ADMIN_COUPLE_CHANGE_ITEM', {response: 'recovered'})
              },
              function (href, $link) {
              }
            )
          },
          'couple-trigger': function () {
            $link.trigger('E2_ADMIN_COUPLE_WILL_THINK')
          }
        }

        var returnValue = true
        var dataJsAction = $link.data('e2-js-action')

        if (dataJsAction) {
          $.each(dataJsAction.split(','), function (index, action) {
            if (typeof actionsVocabulary[action] === 'function') {
              returnValue = false
              actionsVocabulary[action]()
            }
          })
        }

        return returnValue
      }

      $('.e2-admin-item').add('.e2-popup-menu-widget-item').on('click', function () {
        return onClick($(this))
      })
    }

    function initAllAdminCouples () {
      var coupleItemHiddenModifier = 'e2-admin-couple-item_hidden'
      var coupleThinkingModifier = 'e2-admin-couple_thinking'

      var initAdminCouple = function ($couple) {
        if (!$couple.length) return
        var $coupleItems = $couple.find('.e2-admin-couple-item')

        $couple.find('[data-e2-js-action*="couple-trigger"]')
          .on('E2_ADMIN_COUPLE_CHANGE_ITEM', function (event, eventData) {
            if (typeof eventData.response === 'undefined') return

            e2SpinningAnimationStartStop($couple.find('.e2-admin-couple-spinner'), 0)
            $coupleItems.addClass(coupleItemHiddenModifier)
            $couple.find('.e2-admin-couple-item_' + eventData.response).removeClass(coupleItemHiddenModifier)
            $couple.removeClass(coupleThinkingModifier)
          })
          .on('E2_ADMIN_COUPLE_WILL_THINK', function () {
            e2SpinningAnimationStartStop($couple.find('.e2-admin-couple-spinner'), 1)
            $couple.addClass(coupleThinkingModifier)
          })
      }

      $('.e2-admin-couple').each(function () {
        initAdminCouple($(this))
      })

      $(document).on('E2_ADMIN_COUPLE_INIT', function (event, eventData) {
        if (typeof eventData.$couple === 'undefined') return
        initAdminCouple(eventData.$couple)
      })
    }

    initAllAdminItems()
    initAllAdminCouples()
  })
}
