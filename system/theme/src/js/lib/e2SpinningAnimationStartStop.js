function e2SpinningAnimationStartStop ($container, start) {
  const thinkingAnimation = $container.find('animateTransform')[0]
  if (start) {
    thinkingAnimation.setAttribute('repeatCount', 'indefinite')
    thinkingAnimation.beginElement()
  } else {
    thinkingAnimation.setAttribute('repeatCount', '1')
  }
}

export default e2SpinningAnimationStartStop;