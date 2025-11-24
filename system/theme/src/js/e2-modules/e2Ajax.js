import e2NiceError from './e2NiceError'

/**
 * Perform Ajax request to options.url with options.data
 * @param {object}    options
 * @param {string}    options.url
 * @param             options.data
 * @param {function}  [options.success]
 * @param {function}  [options.error]
 * @param {function}  [options.complete]
 * @param {function}  [options.abort]
 **/

function e2Ajax (options) {
  var defaultOptions = {
    type: 'post',
    timeout: 10000,
    dataType: 'json',
    cache: false
  }

  // options.data shows up in several formats (FormData for uploads, plain objects,
  // handcrafted query strings, even jQuery-style arrays). For now we add the token
  // in whichever shape the caller provided so we don’t break existing helpers.
  // If you simplify the callers later, feel free to trim these branches.
  function appendTokenToData (data, token) {
    if (!token) return data

    if (typeof window.FormData !== 'undefined' && data instanceof window.FormData) {
      if (typeof data.has !== 'function' || !data.has('token')) {
        data.append('token', token)
      }
      return data
    }

    if (data === undefined || data === null) {
      return { token: token }
    }

    if (typeof data === 'string') {
      if (!/(?:^|&)token=/.test(data)) {
        data += (data.length ? '&' : '') + 'token=' + encodeURIComponent(token)
      }
      return data
    }

    if (Array.isArray(data)) {
      var hasTokenEntry = data.some(function (entry) {
        return entry && entry.name === 'token'
      })
      if (!hasTokenEntry) {
        data.push({ name: 'token', value: token })
      }
      return data
    }

    if (typeof data === 'object') {
      if (!Object.prototype.hasOwnProperty.call(data, 'token')) {
        data.token = token
      }
      return data
    }

    return data
  }

  var onSuccess = options.success
  var onError = options.error
  var onComplete = options.complete
  var onAbort = options.abort

  delete options.success
  delete options.error
  delete options.complete
  delete options.abort

  var meta = document.querySelector ('meta[name="csrf-token"]')
  var token = (meta && meta.content) ? meta.content : null
  if (token) {
    options.data = appendTokenToData (options.data, token)
  }

  var jqXHR = $.ajax($.extend(defaultOptions, options))

  jqXHR.done(function (response, textStatus, jqXHR) {
    if (typeof response === 'object') {
      if (response['success'] === true) {
        if (typeof onSuccess === 'function') {
          onSuccess(response, textStatus, jqXHR)
        }
      } else {
        if (typeof response['error'] === 'object') {
          var errorObject = response['error']
          var message = typeof errorObject['message'] === 'string'
            ? errorObject['message']
            : 'er--js-server-error'

          e2NiceError({
            message: message,
            debug: {
              data: {
                requestData: options.data,
                response: response
              }
            }
          })
        } else {
          e2NiceError({
            message: 'er--js-server-error',
            debug: {
              message: 'Server responce malformed: `response.error` is not an object',
              data: {
                requestData: options.data,
                response: response
              }
            }
          })
        }
        if (typeof onError === 'function') {
          onError(jqXHR, textStatus)
        }
      }
    } else {
      e2NiceError({
        message: 'er--js-server-error',
        debug: {
          message: 'Server responce malformed: `response` is not an object',
          data: {
            requestData: options.data,
            response: response
          }
        }
      })
      if (typeof onError === 'function') {
        onError(jqXHR, textStatus)
      }
    }
  })

  jqXHR.fail(function (jqXHR, textStatus) {
    if (typeof jqXHR === 'object' && typeof jqXHR.status === 'number' && typeof textStatus === 'string') {
      if (jqXHR.status === 0) {
        if (textStatus === 'abort') {
          if (typeof onAbort === 'function') {
            onAbort(jqXHR, textStatus)
          }
          return false
        } else if (textStatus === 'timeout') {
          e2NiceError({
            message: 'er--js-connection-timeout'
          })
        } else {
          e2NiceError({
            message: 'er--js-appears-offline'
          })
        }
      } else if (jqXHR.status >= 400) {
        e2NiceError({
          message: 'er--js-server-error',
          debug: {
            message: 'Server responded with HTTP status code ' + jqXHR.status,
            data: {
              jqXHR: jqXHR
            }
          }
        })
      } else if (jqXHR.status === 200 && textStatus === 'parsererror') {
        e2NiceError({
          message: 'er--js-server-error',
          debug: {
            message: 'Server response is not JSON',
            data: {
              jqXHR: jqXHR
            }
          }
        })
      } else {
        e2NiceError({
          message: 'er--js-server-error',
          debug: {
            message: 'Unexpected server response HTTP status code ' + jqXHR.status,
            data: {
              jqXHR: jqXHR
            }
          }
        })
      }
    } else {
      e2NiceError({
        message: 'er--js-server-error',
        debug: {
          message: 'Server responce malformed: jqXHR is not an object or it does not contain required fields',
          data: {
            jqXHR: jqXHR
          }
        }
      })
    }
    if (typeof onError === 'function') {
      onError(jqXHR, textStatus)
    }
  })

  jqXHR.always(function () {
    if (typeof onComplete === 'function') {
      onComplete(arguments)
    }
  })

  return jqXHR
}

export default e2Ajax
