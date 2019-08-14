function e2SpinningAnimationStartStop ($container, start) {
  const thinkingAnimation = $container.find('animateTransform')
  if (!thinkingAnimation.length) return
  if (start) {
    thinkingAnimation[0].setAttribute('repeatCount', 'indefinite')
    thinkingAnimation[0].beginElement()
  } else {
    thinkingAnimation[0].setAttribute('repeatCount', '1')
  }
}

export default e2SpinningAnimationStartStop