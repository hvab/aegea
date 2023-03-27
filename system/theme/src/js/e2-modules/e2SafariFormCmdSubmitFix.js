function initSafariFormCmdSubmitFix () {

  // safari loses POST data when cmd+submitting a form,
  // this is a fix by @aelyseev, see:
  // https://codepen.io/aelyseev/pen/eYLWPNR

  const forms = document.querySelectorAll('form')

  for (let i = 0; i < forms.length; i++) {

    let blockNativeSubmit = false

    let form = forms[i]
    let submitButton = form.querySelector('#submit-button')

    form.addEventListener('submit', (e) => {
      if (blockNativeSubmit) {
        e.preventDefault()
      }
    })

    form.addEventListener('keydown', (e) => {
      if (submitButton && submitButton.hasAttribute('disabled')) return
      // if (e.code === 'Enter' && (e.ctrlKey || e.metaKey)) {
      if (e.code === 'Enter' && (e.metaKey)) {
        const prevFormTarget = form.target
        form.target = '_blank'
        blockNativeSubmit = true
        setTimeout(() => {
          blockNativeSubmit = false
        }, 30)
        form.submit()
        form.target = prevFormTarget
      }
    })

    if (submitButton === null) continue

    submitButton.addEventListener('click', (e) => {
      if (submitButton && submitButton.hasAttribute('disabled')) return
      // if (e.ctrlKey || e.metaKey) {
      if (e.metaKey) {
        const prevFormTarget = form.target
        form.target = '_blank'
        blockNativeSubmit = true
        setTimeout(() => {
          blockNativeSubmit = false
        }, 30)
        form.submit()
        form.target = prevFormTarget
      }
    })

  }


}

export default initSafariFormCmdSubmitFix