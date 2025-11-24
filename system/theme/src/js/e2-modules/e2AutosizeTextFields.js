function e2AutosizeTextFields (element) {
  // ‘element’ is the <textarea> to autosize
  element.addEventListener ('input',  e2SetTextField)
  element.addEventListener ('change', e2SetTextField)
  element.addEventListener ('resize', e2SetTextField)

  // Perform an initial sizing right away
  e2SetTextField.call (element)
}

function e2SetTextField () {
  var element = this;

  // used by local copier
  if (element.classList.contains ('e2-textarea-autosize_off')) return

  var myHeight = parseInt (element.clientHeight, 10)
  var lastHeight

  if (element.scrollHeight > myHeight) {
    element.style.height = element.scrollHeight + 'px'
  } else {

    var clonedElement = element.cloneNode (true)
    clonedElement.style.visibility = 'hidden'
    clonedElement.style.position   = 'absolute'
    clonedElement.style.width = element.offsetWidth + 'px'

    // insert clone before the original
    element.parentNode.insertBefore (clonedElement, element);

    // shrink clone until scrollHeight changes
    while (parseInt (clonedElement.scrollHeight, 10) === myHeight) {
      myHeight -= 50
      clonedElement.style.height = myHeight + 'px'
      lastHeight = parseInt (clonedElement.scrollHeight, 10)
      clonedElement.style.height = lastHeight + 'px'
    }

    clonedElement.parentNode.removeChild (clonedElement)

    // apply the measured height to the real element
    element.style.height = lastHeight + 'px';

  }

  // trigger a custom 'autosized' event for local copier
  element.dispatchEvent (new CustomEvent ('autosized'))

}

window.e2AutosizeTextFields = e2AutosizeTextFields

export default e2AutosizeTextFields;