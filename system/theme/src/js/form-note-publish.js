$(function () {
  if (!$('#form-note-publish').length) return

  $('.e2-schedule-contols-revealer').click(function () {
    $('.e2-publish-now-contols').hide()
    $('.e2-schedule-contols').show()
    $('.e2-post-time-control').slideDown(333)
    setTimeout(function () {
      $('.e2-schedule-contols button').removeAttr('disabled')
    }, 333)
    var today = new Date()
    var day = today.getDate()
    if (day < 10) day = '0' + day
    var month = today.getMonth() + 1
    if (month < 10) month = '0' + month
    var year = today.getFullYear()
    var hours = today.getHours()
    var minutes = today.getMinutes()
    hours += 1
    if (minutes === 59) hours += 1
    if (hours < 10) hours = '0' + hours
    $('#stamp').val(day + '.' + month + '.' + year + ' ' + hours + ':00:00')
    $('#stamp').trigger('change')
    return false
  })

  $('.e2-schedule-contols-unrevealer').click(function () {
    $('.e2-schedule-contols').hide()
    $('.e2-schedule-contols button').attr('disabled', 'disabled')
    $('.e2-post-time-control').slideUp(333)
    $('.e2-publish-now-contols').show()
    return false
  })
})
