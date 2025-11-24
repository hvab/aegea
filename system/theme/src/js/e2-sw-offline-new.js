// e2NewNotePath must be defined before this worker is evaluated (see e2m_sw_offline_new)
if (typeof self.e2NewNotePath === 'string') {
  const CACHE_NAME = 'e2-sw-offline-new'

  self.addEventListener ('install', event => {
    event.waitUntil (
      caches.open (CACHE_NAME)
        .then (cache => cache.add (getOfflineRequest ()))
        .catch (() => {})
        .then (() => self.skipWaiting ())
    )
  })

  self.addEventListener ('activate', event => {
    event.waitUntil (
      caches.keys ().then (keys => Promise.all (
        keys.filter (name => name !== CACHE_NAME).map (name => caches.delete (name))
      )).then (() => self.clients.claim ())
    )
  })

  self.addEventListener ('fetch', event => {
    const request = event.request
    if (request.method !== 'GET') return

    const url = new URL (request.url)

    if (request.mode === 'navigate' && url.pathname === self.e2NewNotePath) {
      event.respondWith (serveOfflinePage (request))
      if (self.navigator.onLine) {
        event.waitUntil (refreshOfflinePage (request))
      }
      return
    }

    if (url.origin === self.location.origin) {
      event.respondWith (serveAsset (request))
    }
  })

  function serveOfflinePage (request) {
    const offlineRequest = getOfflineRequest ()

    return caches.match (offlineRequest)
      .then (cached => {
        if (cached) return cached
        return fetch (request).then (response => {
          storeInCache (offlineRequest, response.clone ())
          return response
        })
      })
      .catch (() => caches.match (offlineRequest))
  }

  function refreshOfflinePage (request) {
    const offlineRequest = getOfflineRequest ()

    return fetch (request)
      .then (response => {
        storeInCache (offlineRequest, response.clone ())
      })
      .catch (() => {})
  }

  function serveAsset (request) {
    return caches.match (request)
      .then (cached => {
        if (cached) return cached

        return fetch (request).then (response => {
          storeInCache (request, response.clone ())
          return response
        })
      })
      .catch (() => caches.match (request))
  }

  function storeInCache (request, response) {
    caches.open (CACHE_NAME).then (cache => cache.put (request, response)).catch (() => {})
  }

  function getOfflineRequest () {
    return new Request (self.e2NewNotePath, { credentials: 'include' })
  }
}
