import { isLocalStorageAvailable } from './lib/local-storage'
import cssVarsPolyfill from './lib/css-variables-polyfill'
import viewCounter from './lib/view-counter'
import swing from './lib/swing'
import detect from './lib/detect'
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
      cssVarsPolyfill.run(initSearchField)

      const textField = document.getElementById('text')

      if (textField) textEditorInit(textField)

      function initSearchField () {
        const $searchField = $('.search-field')

        if ($searchField.length) {
          const cssVariable = '--searchFieldMaxWidth'
          const fieldWidth = cssVarsPolyfill.ratifiedVars
            ? parseInt(cssVarsPolyfill.ratifiedVars[cssVariable], 10)
            : parseInt(window.getComputedStyle($searchField.get(0)).getPropertyValue(cssVariable), 10)

          updateSearchFieldStyles($searchField, fieldWidth)
          window.addEventListener('resize', updateSearchFieldStyles.bind(null, $searchField, fieldWidth))
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

      // login
      if ($('#e2-login-sheet').length) {
        var $formLogin = $('#form-login')
        var $formLoginPassword = $formLogin.find('.e2-login-window-password')
        var $formLoginPasswordChecking = $formLogin.find('.e2-login-window-password-checking')
        var mustSubmit = false

        $formLoginPassword.focus()

        $formLogin.submit(function () {
          if (mustSubmit) return true

          $formLogin.find('.input-disableable').prop('disabled', true)
          $formLoginPassword.blur()
          e2SpinningAnimationStartStop($formLoginPasswordChecking, 1)
          $formLoginPasswordChecking.fadeIn(333)

          $.ajax({
            url: $('#e2-check-password-action').attr('href'),
            type: 'post',
            timeout: 10000,
            data: {
              password: $formLoginPassword.val()
            },
            success: function (response) {
              response = JSON.parse(response)
              $('.input-disableable').removeAttr('disabled')
              if (response['data']['password-correct']) {
                e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
                $formLoginPasswordChecking.hide()
                $('#password-correct').fadeIn(333)
                mustSubmit = true
                setTimeout(function () {
                  $formLogin.submit()
                }, 333)
              } else {
                e2SpinningAnimationStartStop($formLoginPasswordChecking, 0)
                $formLoginPasswordChecking.fadeOut(333)
                $formLoginPassword.focus()
                swing($('#e2-login-window')[0])
              }
            },
            error: function () {
              mustSubmit = true
              $formLogin.submit()
            }
          })
          return false
        })
      }

      // visual login
      if ($('#e2-visual-login').length) {
        $(document).mousemove(function (event) {
          var o = $('#e2-visual-login').offset()
          var x1 = o.left
          var y1 = o.top
          var x2 = event.pageX
          var y2 = event.pageY
          var l = Math.pow((Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2)), 0.5)
          l = Math.max(Math.min(l, 600), 100)
          l = (l - 100) / 500
          $('#e2-visual-login').css('opacity', 0.25 + (1 - l) * 0.75)
        })
        $('#e2-visual-login').on('click', function () {
          $('#e2-visual-login').css('visibility', 'hidden')
          $('#e2-login-sheet').addClass('e2-show')
          setTimeout(function () {
            $('#e2-password').focus()
          }, 100)
          return false
        })
      }

      // if there is subscribe sheet, show subscribe button
      if ($('#e2-subscribe-sheet').length) {
        $('#e2-note-subscribe-button').addClass('e2-note-subscribe-button-visible')
      }

      // show subscribe window on click on subscribe button
      if ($('#e2-note-subscribe-button').length) {
        $('#e2-note-subscribe-button').click(function () {
          $('#e2-subscribe-sheet').addClass('e2-show')
          return false
        })
      }

      document.$e2HideLoginSheet = function () {
        $('#e2-password').blur()
        $('#e2-login-sheet').removeClass('e2-show')
        $('#e2-visual-login').css('visibility', 'visible')
      }

      document.$e2HideSubscribeSheet = function () {
        $('#e2-subscribe-sheet').removeClass('e2-show')
      }

      // hide login window on click outside (on sheet)
      if ($('#e2-login-sheet').length) {
        $('#e2-login-sheet').click(function (event) {
          if ($('#e2-login-sheet').hasClass('e2-hideable')) {
            if (event.target === this) document.$e2HideLoginSheet()
          }
        })
      }

      // hide subscribe window on click outside (on sheet)
      if ($('#e2-subscribe-sheet').length) {
        $('#e2-subscribe-sheet').on('click', function (event) {
          if (event.target === this) document.$e2HideSubscribeSheet()
        })
      }

      // hide all sheets on esc
      $(document).on('keyup', function (event) {
        if ((event.keyCode === 27)) {
          document.$e2HideSubscribeSheet()
          if ($('#e2-login-sheet').hasClass('e2-hideable')) {
            document.$e2HideLoginSheet()
          }
        }
      })

      // don't search empty string
      $('#e2-search').on('submit', function () {
        if (/^ *$/.test($('#query').val())) return false
      })

      // search focus
      const $searchFieldInput = $('.search-field__input')
      const $searchFieldIcon = $('.search-field__zoom-icon')
      const $searchFieldTagsIcon = $('.search-field__tags-icon')

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
      $searchFieldIcon.click(() => $searchFieldInput.focus())

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
        if (window.event) event = window.event
        var target = (event.srcElement || event.target).tagName
        if (/textarea|input/i.test(target)) return

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

      if (document.addEventListener) {
        document.addEventListener('keyup', e2CtrlNavi, false)
      } else if (document.attachEvent) {
        document.attachEvent('onkeydown', e2CtrlNavi)
      }

      const $notes = $('.e2-note')

      if ($notes.length && isLocalStorageAvailable) {
        const endpointSuffix = $('#e2-note-read-href').attr('href')
        $notes.map((index, node) => {
          const $note = $(node)
          if ($note.find('.e2-published').length) {
            initViewCounter({$note, endpointSuffix})
          }
        })
      }

      function initViewCounter ({$note, endpointSuffix}) {
        const $link = $note.find('h1 a')

        const noteId = $note.attr('id').replace('e2-note-', '')
        const endpointBody = $link.length ? $link.attr('href') : (window.location.origin + window.location.pathname)
        const endpointUrl = endpointBody + endpointSuffix

        viewCounter({noteId, endpointUrl})
      }
    }

    initObsoleteFunction()

    // Third init popup menus
    initAllPopupMenus()
  })
}
