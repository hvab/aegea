import getTransitionEvent from '../lib/getTransitionEvent'

/**
 * Show beautiful error message
 * @param {object}    error
 * @param {string}    [error.message]
 * @param {object}    [error.debug]
 * @param {string}    [error.debug.message]
 * @param {object}    [error.debug.data]
 **/

function e2NiceError (error) {
  var $element = $('.e2-nice-error')
  var $inner = $element.find('.e2-nice-error-inner')
  var hiddenModificator = 'e2-nice-error_hidden'

  var stringLocalizations = {
    'en': {
      'er--js-server-error': 'Server error',
      'er--js-appears-offline': 'The connection appears to be offline',
      'er--js-connection-timeout': 'Server does not respond for too long',
      'er--js-file-upload-not-supported': 'The browser does not support file upload',
      'er--js-no-files-to-upload': 'No files to upload',
      'er--js-can-upload-only-one-file': 'Only one file may be uploaded here',
      'er--supported-image-types': 'Supported image types:',
      'er--supported-file-types': 'Supported file types:',
          },
    'ru': {
      'er--js-server-error': 'Ошибка на сервере',
      'er--js-appears-offline': 'Похоже, что нет интернета',
      'er--js-connection-timeout': 'Сервер не отвечает слишком долго',
      'er--js-file-upload-not-supported': 'Браузер не поддерживает загрузку файлов',
      'er--js-no-files-to-upload': 'Нет файлов для загрузки',
      'er--js-can-upload-only-one-file': 'Можно загрузить только одно изображение',
      'er--supported-image-types': 'Поддерживаемые типы изображений:',
      'er--supported-file-types': 'Поддерживаемые типы файлов:',
          },
    'fr': {
      'er--js-server-error': 'Erreur sur le serveur',
      'er--js-appears-offline': 'La connexion semble être hors ligne',
      'er--js-connection-timeout': 'Le serveur ne répond pas trop longtemps',
      'er--js-file-upload-not-supported': 'Le navigateur ne prend pas en charge le téléchargement de fichiers',
      'er--js-no-files-to-upload': 'Aucun fichier à télécharger',
      'er--js-can-upload-only-one-file': 'Un seul fichier peut être téléchargé ici',
      'er--supported-image-types': 'Types d’image pris en charge :',
      'er--supported-file-types': 'Types de fichiers pris en charge :',
          },
    'it': {
      'er--js-server-error': 'Errore sul server',
      'er--js-appears-offline': 'La connessione sembra di mancare',
      'er--js-connection-timeout': 'Il server non risponde per troppo tempo',
      'er--js-file-upload-not-supported': 'Il navigatore web non supporta caricamento dei fili',
      'er--js-no-files-to-upload': 'Non ci sono fili da caricare',
      'er--js-can-upload-only-one-file': 'Solo un file può essere caricato qui',
      'er--supported-image-types': 'Tipi di immagine supportati:',
      'er--supported-file-types': 'Tipi di file supportati:',
          },
    'be': {
      'er--js-server-error': 'Памылка на серверы',
      'er--js-appears-offline': 'Падобна на тое, што няма інтэрнэту',
      'er--js-connection-timeout': 'Сервер не адказвае занадта доўга',
      'er--js-file-upload-not-supported': 'Браузэр не падтрымлівае загрузку файлаў',
      'er--js-no-files-to-upload': 'Няма файлаў для загрузкі',
      'er--js-can-upload-only-one-file': 'Можна загрузіць толькі адну выяву',
      'er--supported-image-types': 'Падтрымлiваемыя тыпы выяў:',
      'er--supported-file-types': 'Падтрымлiваемыя тыпы файлаў:',
          },
    'uk': {
      'er--js-server-error': 'Помилка на сервері',
      'er--js-appears-offline': 'Схоже, що немає інтернету',
      'er--js-connection-timeout': 'Сервер не відповідає занадто довго',
      'er--js-file-upload-not-supported': 'Браузер не підтримує завантаження файлів',
      'er--js-no-files-to-upload': 'Немає файлів для завантаження',
      'er--js-can-upload-only-one-file': 'Можна завантажити лише одне зображення',
      'er--supported-image-types': 'Підтримувані типи зображень:',
      'er--supported-file-types': 'Підтримувані типи файлів:',
          }
  }

  var transitionEvent = getTransitionEvent()

  function showMessage () {
    var errorText = error.message ? error.message : ''
    var lang = $('html').attr('lang') || 'en'

    if (errorText) {
      if (typeof stringLocalizations[lang] !== 'undefined' && typeof stringLocalizations[lang][error.message] !== 'undefined') {
        errorText = stringLocalizations[lang][error.message]
      } else if (typeof stringLocalizations['en'][error.message] !== 'undefined') {
        errorText = stringLocalizations['en'][error.message]
      }

      if ($element.hasClass(hiddenModificator)) {
        $inner.html(errorText).promise().done(function () {
          $element.removeClass(hiddenModificator)
          $(document).on('mousedown.e2NiceError keydown.e2NiceError', function () {
            $(document).off('.e2NiceError')
            hideMessage()
          })
        })
      } else {
        hideMessage(function () {
          $inner.html(errorText).promise().done(function () {
            $element.removeClass(hiddenModificator)
            $(document).on('mousedown.e2NiceError keydown.e2NiceError', function () {
              $(document).off('.e2NiceError')
              hideMessage()
            })
          })
        })
      }
    }

    if (typeof error.debug === 'object' && typeof console === 'object') {
      var errorColor
      var backgroundColor

      if (typeof window.getComputedStyle === 'function' && typeof window.getComputedStyle(document.documentElement).getPropertyValue === 'function') {
        errorColor = window.getComputedStyle(document.documentElement).getPropertyValue('--errorColor')
        backgroundColor = window.getComputedStyle(document.documentElement).getPropertyValue('--backgroundColor')
      }

      if (typeof console.log === 'function') {
        if (typeof error.debug.message === 'string') {
          console.log('%c ' + error.debug.message + ' ', 'background: ' + (errorColor ? errorColor : '#D20D19') + '; color: ' + (backgroundColor ? backgroundColor : '#fff') + ';')
        } else if (typeof errorText === 'string') {
          console.log('%c ' + errorText + ' ', 'background: ' + (errorColor ? errorColor : '#D20D19') + '; color: ' + (backgroundColor ? backgroundColor : '#fff') + ';')
        }
      }

      if (typeof console.dir === 'function' && typeof console.log === 'function') {
        if (typeof error.debug.data === 'object') {
          $.each(error.debug.data, function(debugDataKey, debugDataValue) {
            if (typeof debugDataValue === 'object' && debugDataValue instanceof FormData && typeof debugDataValue.entries === 'function') {
              console.log(debugDataKey)
              for (var formDataObject of debugDataValue.entries()) {
                console.dir(formDataObject[1])
              }
            } else {
              console.log(debugDataKey)
              console.dir(debugDataValue)
            }
          })
        }
      }
    }
  }

  function hideMessage (callbackFunction) {
    if (typeof callbackFunction === 'function') {
      if (transitionEvent) {
        $element.off(transitionEvent + '.e2NiceError').on(transitionEvent + '.e2NiceError', function () {
          $element.off(transitionEvent + '.e2NiceError')
          callbackFunction()
        })
        $element.addClass(hiddenModificator)
      } else {
        $element.addClass(hiddenModificator)
        callbackFunction()
      }
    } else {
      $element.addClass(hiddenModificator)
    }
  }

  showMessage()
}

export default e2NiceError
