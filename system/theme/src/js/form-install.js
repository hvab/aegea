import e2SpinningAnimationStartStop from './lib/e2SpinningAnimationStartStop'

var dbCount = 0
var bingo = false
var initialGlassCheck = true
var xhrCheckDBConfig, xhrListDatabases

function e2UpdateSubmittability () {
  var shouldBeDisabled = (
    (!bingo) ||
    /^ *$/.test($('#password').val())
  )

  if (shouldBeDisabled) {
    $('#submit-button').attr('disabled', 'disabled')
  } else {
    $('#submit-button').removeAttr('disabled')
  }
}

function e2AllCompleted () {
  if (xhrCheckDBConfig) xhrCheckDBConfig.abort()
  if (xhrListDatabases) xhrListDatabases.abort()
  if (Boolean(dbCount) === ($('#db-database-list').css('display') === 'none')) {
    $('#db-database-list').add('#db-database').toggle()
  }
  $('.e2-glass').fadeOut(333)
  initialGlassCheck = false
}

function e2CheckDbConfig (me) {
  dbCount = 0

  var completedCheckDBConfig, completedListDatabases

  if (me) {
    e2SpinningAnimationStartStop($('.e2-ajax-loading'), 1)
    $('.e2-ajax-loading').fadeIn(333)
  }

  var ajaxData = {
    'db-server': $('#db-server').val(),
    'db-user': $('#db-user').val(),
    'db-password': $('#db-password').val(),
    'db-database': $('#db-database').val()
  }

  $.ajaxSetup({
    type: 'post',
    timeout: 10000,
    data: ajaxData
  })

  $('#db-server').get(0).e2OldValue = $('#db-server').val()
  $('#db-user').get(0).e2OldValue = $('#db-user').val()
  $('#db-password').get(0).e2OldValue = $('#db-password').val()
  $('#db-database').get(0).e2OldValue = $('#db-database').val()

  clearTimeout(document.e2TimeOut)

  document.e2TimeOut = setTimeout(function () {
    if (xhrCheckDBConfig) xhrCheckDBConfig.abort()
    if (xhrListDatabases) xhrListDatabases.abort()

    xhrCheckDBConfig = $.ajax({

      url: $('#e2-check-db-config-action').attr('href'),

      success: function (msg) {
        $('.db-everything-ok').removeClass('e2-verified').addClass('e2-wrong')

        if (msg === 'no-connect') {
        } else if (msg === 'server-responding') {
          if (initialGlassCheck) $('#db-user').focus()
          $('.db-server-ok').removeClass('e2-wrong').addClass('e2-verified')
        } else if (msg === 'server-lets-in') {
          $('.db-user-password-ok').removeClass('e2-wrong').addClass('e2-verified')
          $('.db-server-ok, db-user-password-ok').removeClass('e2-wrong').addClass('e2-verified')
        } else if (msg === 'data-incomplete') {
          $('#db-database-exists').slideUp(333)
          $('#db-database-incomplete').slideDown(333)
          $('.db-server-ok, db-user-password-ok').removeClass('e2-wrong').addClass('e2-verified')
        } else if (msg === 'bingo-data-exists') {
          $('#db-database-incomplete').slideUp(333)
          $('#db-database-exists').slideDown(333)
          $('.db-everything-ok').removeClass('e2-wrong').addClass('e2-verified')
        } else if (msg === 'bingo') {
          $('#db-database-incomplete').slideUp(333)
          $('#db-database-exists').slideUp(333)
          if (initialGlassCheck) $('#password').focus()
          $('.db-everything-ok').removeClass('e2-wrong').addClass('e2-verified')
        }

        // if ((msg !== 'no-connect') && (msg !== 'server-responding')) {
        if (msg !== 'no-connect') {
          if (xhrCheckDBConfig) xhrCheckDBConfig.abort()
          if (xhrListDatabases) xhrListDatabases.abort()
          xhrListDatabases = $.ajax({

            url: $('#e2-list-databases-action').attr('href'),

            success: function (msg) {
              if (msg) {
                var dbs = msg.split('|')
                var valBefore = $('#db-database').val()
                if ($('#db-database').val() === '') {
                  $('#db-database').val(dbs[0])
                } else {
                  for (var i in dbs) {
                    if (dbs[i].match(RegExp('^' + $('#db-database').val() + ''))) {
                      $('#db-database').val(dbs[i])
                      break
                    }
                  }
                }
                $('#db-database-list').empty()
                for (var k in dbs) {
                  ++dbCount
                  $('#db-database-list')
                    .append(
                      '<option id="db-database-option-' + dbs[k] + '">' +
                      dbs[k] +
                      '<' + '/option>'
                    )
                }

                $('#db-database-list #db-database-option-' + $('#db-database').val())
                  .attr('selected', 'selected')

                $('#db-database').val($('#db-database-list option:selected').val())
                $('#db-database-list').addClass('e2-verified')
                if (valBefore !== $('#db-database').val()) {
                  e2CheckDbConfig()
                }
              }
            },

            error: function () {
              if (initialGlassCheck) $('#db-database').focus()
            },

            complete: function (xhr) {
              completedListDatabases = true
              if (completedCheckDBConfig && completedListDatabases) e2AllCompleted()
            }

          })
        } else {
          completedListDatabases = true
        }

        bingo = ((msg === 'bingo-data-exists') || (msg === 'bingo'))
        e2UpdateSubmittability()
      },

      error: function (msg) {
        if (initialGlassCheck) {
          $('.input-editable').removeAttr('disabled')
          $('#db-server').add('#db-user').add('#db-password').add('#db-database').val('')
          $('#db-server').focus()
          setTimeout(function () { $('.e2-glass').fadeOut(333) }, 333)
          initialGlassCheck = false
        }
      },

      complete: function (xhr) {
        $('.input-editable').removeAttr('disabled')
        completedCheckDBConfig = true
        if (completedCheckDBConfig && completedListDatabases) e2AllCompleted()
        $('#e2-console').html(xhr.responseText)
        // if (me) $ ('#' + (me.id) + '-checking').fadeOut (333)
        e2SpinningAnimationStartStop($('.e2-ajax-loading'), 0)
        $('.e2-ajax-loading').fadeOut(333)
      }

    })
  }, 333)
}

$('.input-editable').attr('disabled', 'disabled')

e2CheckDbConfig()

$('.input-editable').bind('input', function () {})

$('.e2-livecheckable').bind('input', function () {
  bingo = false
  $('.db-everything-ok').removeClass('e2-verified').removeClass('e2-wrong')
  e2UpdateSubmittability()
})

$('.e2-livecheckable').bind('blur', function () {
  if ((typeof this.e2OldValue === 'undefined') || ($(this).val() !== this.e2OldValue)) {
    $(this).removeClass('e2-verified').removeClass('e2-wrong')
    e2CheckDbConfig(this)
  }
})

$('#db-database-list').bind('change', function () {
  $('#db-database').val($('#db-database-list').val())
  e2CheckDbConfig(this)
})

$('#password').bind('input', e2UpdateSubmittability)
