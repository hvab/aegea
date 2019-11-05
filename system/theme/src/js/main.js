import { isLocalStorageAvailable } from './lib/local-storage'
import cssVarsPolyfill from './lib/css-variables-polyfill'
import viewCounter from './lib/view-counter'
import swing from './lib/swing'
import detect from './lib/detect'
import e2Ajax from './e2-modules/e2Ajax'
import e2NiceError from './e2-modules/e2NiceError'
import e2SpinningAnimationStartStop from './e2-modules/e2SpinningAnimationStartStop'
import textEditorInit from './lib/text-editor'
import initFormComment from './e2-modules/form-comment'
import initAllPopupMenus from './e2-modules/e2PopupMenu'

if (typeof $ !== 'undefined') {
  $(function () {
    // First init imports
    initFormComment()

    // Second init obsolete functions
    function initObsoleteFunction () {
      const textField = document.getElementById('text')
      if (textField) textEditorInit(textField)

      // former pseudohover.js
      var $pseudohoveredLinks = $()
      $(document)
        .on('mouseover', 'a[href]', function () {
          var $this = $(this)
          var h = $this.attr('href')

          if (h && h !== '#' && !h.match(/^javascript:/)) {
            $pseudohoveredLinks = $('a[href="' + h + '"]').addClass('hover')
          }
        })
        .on('mouseout', 'a[href]', function (event) {
          if (typeof event === 'object' && typeof event.currentTarget === 'object' && typeof event.relatedTarget === 'object' && $(event.currentTarget).find(event.relatedTarget).length > 0) {
            return true
          }
          $pseudohoveredLinks.removeClass('hover')
          $pseudohoveredLinks = $()
        })

      // update a hrefs with link redirects
      $('a').each(function () {
        const redir = $(this).attr('linkredir')

        if (redir) {
          const $this = $(this)

          $this
            .attr('href', redir + $this.attr('href'))
            .attr('linkredir', '')
        }
      })

      // login popup
      if ($('#e2-login-sheet').length) {
        var $loginButton = $('#e2-visual-login')
        var $popupLogin = $('#e2-login-sheet')

        var $formLogin = $popupLogin.find('#form-login')
        var $formLoginPassword = $formLogin.find('#e2-password')
        var $formLoginPasswordChecking = $formLogin.find('.e2-login-window-password-checking')
        var mustSubmit = false

        $formLoginPassword.focus()

        $formLogin.on('submit', function (event) {
          if (mustSubmit) return true

          event.preventDefault()

          $formLogin.find('.input-disableable').prop('disabled', true)
          $formLoginPassword.blur()
          e2SpinningAnimationStartStop($formLoginPasswordChecking, 1)
          $formLoginPasswordChecking.fadeIn(333)

          var ajaxRequest = e2Ajax({
            url: $('#e2-check-password-action').attr('href'),
            data: {
              password: $formLoginPassword.val()
            },
            success: function (response) {
              $formLogin.find('.input-disableable').prop('disabled', false)

              if (typeof response['data'] === 'undefined' || typeof response['data']['password-correct'] === 'undefined') {
                e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
                $formLoginPasswordChecking.fadeOut(333)
                e2NiceError({
                  message: 'er--js-server-error',
                  debug: {
                    message: 'Server response malformed',
                    data: {
                      response: response
                    }
                  }
                })
                return false
              }

              if (response['data']['password-correct']) {
                e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
                $formLoginPasswordChecking.hide()
                $('#password-correct').fadeIn(333, function () {
                  mustSubmit = true
                  $formLogin.submit()
                })
              } else {
                e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
                $formLoginPasswordChecking.fadeOut(333)
                $formLoginPassword.focus()
                swing($('#e2-login-window')[0])
              }
            },
            error: function () {
              $formLogin.find('.input-disableable').prop('disabled', false)
              e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
              $formLoginPasswordChecking.fadeOut(333)
            },
            abort: function () {
              $formLogin.find('.input-disableable').prop('disabled', false)
              e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
              $formLoginPasswordChecking.fadeOut(333)
            }
          })

          $formLogin.data('formLoginAjaxRequest', ajaxRequest)

          return false
        })

        $popupLogin
          .on('E2_SHOW_LOGIN_SHEET', function () {
            $popupLogin.addClass('e2-show')

            setTimeout(function () {
              $formLoginPassword.focus()
            }, 100)

            $loginButton.addClass('e2-visual-login_hidden')
          })
          .on('E2_HIDE_LOGIN_SHEET', function () {
            if (!$popupLogin.hasClass('e2-hideable')) {
              return false
            }

            $formLoginPassword.blur()
            $popupLogin.removeClass('e2-show')

            if (typeof $formLogin.data('formLoginAjaxRequest') === 'object') {
              $formLogin.data('formLoginAjaxRequest').abort()
            }

            $loginButton.removeClass('e2-visual-login_hidden')
          })

        // hide login window on click outside (on sheet)
        $popupLogin.on('click', function (event) {
          if (event.target === this) $('#e2-login-sheet').trigger('E2_HIDE_LOGIN_SHEET')
        })

        // show login popup
        if ($loginButton.length) {
          $(document).on('mousemove', function (event) {
            var o = $loginButton.offset()
            var x1 = o.left
            var y1 = o.top
            var x2 = event.pageX
            var y2 = event.pageY
            var l = Math.pow((Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2)), 0.5)
            l = Math.max(Math.min(l, 600), 100)
            l = (l - 100) / 500
            $loginButton.css('opacity', 0.25 + (1 - l) * 0.75)
          })

          $loginButton.on('click', function (event) {
            event.preventDefault()
            $popupLogin.trigger('E2_SHOW_LOGIN_SHEET')
            return false
          })
        }
      }

      // subscribe popup
      if ($('#e2-subscribe-sheet').length && $('#e2-note-subscribe-button').length) {
        var $subscribeButton = $('#e2-note-subscribe-button')
        var $popupSubscribe = $('#e2-subscribe-sheet')

        $popupSubscribe.on('E2_SHOW_SUBSCRIBE_SHEET', function () {
          $(this).addClass('e2-show')
        }).on('E2_HIDE_SUBSCRIBE_SHEET', function () {
          $(this).removeClass('e2-show')
        }).on('click', function (event) {
          if (event.target === this) $('#e2-subscribe-sheet').trigger('E2_HIDE_SUBSCRIBE_SHEET')
        })

        $subscribeButton.addClass('e2-note-subscribe-button-visible').on('click', function (event) {
          event.preventDefault()
          $('#e2-subscribe-sheet').trigger('E2_SHOW_SUBSCRIBE_SHEET')
          return false
        })
      }

      // hide all sheets on esc
      $(document).on('keyup', function (event) {
        if ((event.keyCode === 27)) {
          $('#e2-subscribe-sheet').trigger('E2_HIDE_SUBSCRIBE_SHEET')
          $('#e2-login-sheet').trigger('E2_HIDE_LOGIN_SHEET')
        }
      })

      // search
      if ($('#e2-search').length) {
        var $searchForm = $('#e2-search')

        var initSearchField = function () {
          const $searchField = $('.search-field')

          function updateStyles (id, styles) {
            if (typeof styles === 'undefined') {
              styles = id
              id = null
            }

            const head = document.head || document.getElementsByTagName('head')[0]

            if (id) {
              let styleNode = document.getElementById(id)

              if (!styleNode) {
                styleNode = document.createElement('style')
                styleNode.id = id
                styleNode.innerHTML = styles
                head.appendChild(styleNode)
              } else {
                styleNode.innerHTML = styles
              }
            } else {
              const styleNode = document.createElement('style')
              styleNode.innerHTML = styles
              head.appendChild(styleNode)
            }
          }

          function updateSearchFieldStyles ($field, width) {
            const fieldLeft = $field.get(0).getBoundingClientRect().left
            let maxWidth

            if ($field.hasClass('search-field-left-anchored')) {
              maxWidth = $(window).width() - fieldLeft
            } else {
              maxWidth = fieldLeft
            }

            if (maxWidth < width) {
              updateStyles('search-field__input', `.search-field { --searchFieldMaxWidth: ${maxWidth}px; }`)
            } else {
              updateStyles('search-field__input', `.search-field { --searchFieldMaxWidth: ${width}px; } .search-field__input { max-width: ${maxWidth}px; }`)
            }

            cssVarsPolyfill.run()
          }

          if ($searchField.length) {
            const cssVariable = '--searchFieldMaxWidth'
            const fieldWidth = cssVarsPolyfill.ratifiedVars
              ? parseInt(cssVarsPolyfill.ratifiedVars[cssVariable], 10)
              : parseInt(window.getComputedStyle($searchField.get(0)).getPropertyValue(cssVariable), 10)

            updateSearchFieldStyles($searchField, fieldWidth)
            $(window).on('resize', updateSearchFieldStyles.bind(null, $searchField, fieldWidth))
          }
        }
        cssVarsPolyfill.run(initSearchField)

        // don't search empty string
        $searchForm.on('submit', function () {
          if (/^ *$/.test($('#query').val())) return false
        })

        // search focus
        var $searchFieldInput = $searchForm.find('.search-field__input')
        var $searchFieldIcon = $searchForm.find('.search-field__zoom-icon')
        var $searchFieldTagsIcon = $searchForm.find('.search-field__tags-icon')

        $searchFieldInput
          .on('focusin', function () {
            $searchFieldInput.addClass('search-field__input_focused')
            $searchFieldIcon.addClass('search-field__zoom-icon_focused')
          })
          .on('focusout', function (e) {
            if ($(e.relatedTarget).hasClass('search-field__tags-icon') || ($searchFieldTagsIcon.length && $searchFieldTagsIcon.is(':active'))) return

            $searchFieldIcon.removeClass('search-field__zoom-icon_focused')
            $searchFieldInput.removeClass('search-field__input_focused')
          })
        $searchFieldIcon.on('click', function () {
          $searchFieldInput.focus()
        })
      }

      // ctrl+enter sends forms
      $(document).on('keydown keyup keypress', function (event) {
        if ((event.keyCode === 13) || (event.which === 13)) {
          var target = event.target || event.srcElement
          if (target) {
            if (target.form) {
              var $targetForm = $(target.form)
              if ($targetForm.hasClass('e2-enterable')) return
              if (!event.ctrlKey && $(target).is('textarea')) return
              event.preventDefault()
              if (event.ctrlKey && (event.type === 'keydown')) {
                if ($targetForm.find('#submit-button').length && !$targetForm.find('#submit-button').is(':disabled')) {
                  $targetForm.submit()
                }
              }
              return false
            }
          }
        }
      })

      // alt+e edits
      $(document).on('keyup', function (event) {
        if (((event.keyCode === 69) || (event.which === 69)) && event.altKey) {
          if ($('.e2-edit-link').length > 0) {
            window.location.href = $('.e2-edit-link').eq(0).attr('href')
          }
        }
      })

      // ctrl-navigation
      function e2CtrlNavi (event) {
        var eventTargetTag = event.target.nodeName.toLowerCase()
        if (eventTargetTag === 'input' || eventTargetTag === 'textarea' || eventTargetTag === 'select' || eventTargetTag === 'option' || eventTargetTag === 'button' || (typeof $(event.target).attr('contenteditable') !== 'undefined' && $(event.target).attr('contenteditable') !== 'false')) {
          return
        }

        if ((detect.mac && event.altKey && !event.shiftKey) || (!detect.mac && event.ctrlKey)) {
          var link = null
          if (event.keyCode === 37) link = document.getElementById('link-prev')
          if (event.keyCode === 39) link = document.getElementById('link-next')
          if (event.keyCode === 38) link = document.getElementById('link-later')
          if (event.keyCode === 40) link = document.getElementById('link-earlier')
          if (link && link.href) {
            window.location.href = link.href
            if (window.event) window.event.returnValue = false
            if (event.preventDefault) event.preventDefault()
          }
        }
      }
      $(document).on('keyup', e2CtrlNavi)

      // autosize text fields
      function e2AutosizeTextFields () {
        var element = $('.e2-textarea-autosize')[0]
        // this should be expanded to support multiple elements
        if (element) {
          var myHeight = parseInt(element.style.height)
          if (element.scrollHeight > myHeight) {
            element.style.height = (element.scrollHeight) + 'px'
          } else {
            while (element.scrollHeight === myHeight) {
              myHeight -= 50
              element.style.height = (myHeight) + 'px'
              element.style.height = (element.scrollHeight) + 'px'
            }
          }

          $(element).trigger('autosized')
        }
      }
      $('.e2-textarea-autosize').on('input change resize', e2AutosizeTextFields)
      e2AutosizeTextFields()

      // notes
      var $notes = $('.e2-note')
      if ($notes.length && isLocalStorageAvailable) {
        const endpointSuffix = $('#e2-note-read-href').attr('href')

        var initViewCounter = function ({$note, endpointSuffix}) {
          const $link = $note.find('h1 a')

          const noteId = $note.attr('id').replace('e2-note-', '')
          const endpointBody = $link.length ? $link.attr('href') : (window.location.origin + window.location.pathname)
          const endpointUrl = endpointBody + endpointSuffix

          viewCounter({noteId, endpointUrl})
        }

        $notes.map((index, node) => {
          const $note = $(node)
          if ($note.find('.e2-published').length) {
            initViewCounter({$note, endpointSuffix})
          }
        })
      }
    }
    initObsoleteFunction()

    // Third init popup menus
    initAllPopupMenus()
  })
}
