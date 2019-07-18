const localStorage = window.localStorage

const isLocalStorageAvailable = (() => {
  try {
    localStorage.setItem('test', 'test')
    localStorage.removeItem('test')

    return true
  } catch (e) {
    return false
  }
})()

export { localStorage, isLocalStorageAvailable }
