import { localStorage, isLocalStorageAvailable } from './lib/local-storage'

document.e2 = document.e2 || {}

if (isLocalStorageAvailable) {
  document.e2.localCopies = {
    _lsKey: 'copies-info',
    _lsPrefix: 'copy-',
    _cookieName: document.e2.cookiePrefix + 'local_copies',

    getListName () {
      return this._lsKey
    },

    getPrefix () {
      return this._lsPrefix
    },

    getName (id) {
      return this._lsPrefix + id
    },

    save (id, copy) {
      localStorage.setItem(this.getName(id), JSON.stringify(copy))
      this.addToList(id, copy)
    },

    remove (id) {
      localStorage.removeItem(this.getName(id))
      this.removeFromList(id)
    },

    get (id, draftTime, serverTime) {
      let copy = false

      try {
        copy = JSON.parse(localStorage.getItem(this.getName(id)))

        if (!copy) return false
      } catch (e) {
        return false
      }

      if (!serverTime || !draftTime) {
        return copy
      } else {
        if (this.isCopyOutdated(copy, draftTime, serverTime)) {
          this.remove(id)
          return false
        }

        return copy
      }
    },

    getList () {
      try {
        return JSON.parse(localStorage.getItem(this._lsKey)) || {}
      } catch (e) {
        return {}
      }
    },

    addToList (id, copy) {
      const list = this.getList()

      if (!list.hasOwnProperty(id)) {
        list[id] = { isPublished: copy.isPublished, timestamp: copy.timestamp }
        localStorage.setItem(this._lsKey, JSON.stringify(list))
        this.updateCookie(list)
      }
    },

    removeFromList (id) {
      const list = this.getList()

      if (list.hasOwnProperty(id)) {
        delete list[id]
        localStorage.setItem(this._lsKey, JSON.stringify(list))
        this.updateCookie(list)
      }
    },

    doesCopyExist (id) {
      return localStorage.hasOwnProperty(this.getName(id))
    },

    // returns local copy if it is not outdated, else removes this copy (if it exists) and returns false
    isCopyOutdated (copy, draftTime, serverTime) {
      if (!draftTime || !serverTime) return false

      const copyTime = +copy.timestamp
      const localTime = (new Date()).getTime()
      const diffTime = serverTime - localTime

      if (Math.abs(diffTime) > 3600 * 60 * 1000) {
        // if diff time more than 3 mins then we decide that server in another timezone
        draftTime -= diffTime
      }

      return copyTime <= draftTime
    },

    checkOutdatedCopies () {
      const serverNotes = document.e2.noteLastModifiedsById || {}
      const list = this.getList()

      for (let key in list) {
        if (key === 'new') continue
        if (!serverNotes.hasOwnProperty(key)) {
          this.remove(key)
          continue
        }

        if (this.isCopyOutdated(list[key], serverNotes[key] * 1000, document.e2.serverTime * 1000)) {
          this.remove(key)
        }
      }
    },

    generateCookie () {
      const matches = document.cookie.match(new RegExp(
        '(?:^|; )' + this._cookieName.replace(/([.$?*|{}()[]\\\/\+^])/g, '\\$1') + '=([^;]*)'
      ))

      if (!matches) this.updateCookie()
    },

    updateCookie (list) {
      list = list || this.getList()

      const ids = []

      for (let key in list) {
        if (key === 'new') continue

        ids.push(key)
      }

      if (ids.length) {
        document.cookie = this._cookieName + '=' + ids.join(',') + ';path=/'
      } else {
        const d = new Date()
        d.setTime(d.getTime() - 1)
        document.cookie = this._cookieName + '="";path=/;expires=' + d.toUTCString()
      }
    }
  }

  document.e2.localCopies.checkOutdatedCopies()

  // let's create cookie if it was removed
  document.e2.localCopies.generateCookie()
}
