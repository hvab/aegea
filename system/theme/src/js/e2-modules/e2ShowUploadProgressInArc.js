function e2ShowUploadProgressInArc (arc, progressPercent) {
  const maxDash = 245
  const fakeProgress = Math.max(Math.min(progressPercent, 0.9), 0.1)
  const progressDash = Math.floor(maxDash - fakeProgress * maxDash)

  arc.style.strokeDashoffset = progressDash
}

export default e2ShowUploadProgressInArc
