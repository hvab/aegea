if ($) $ (function () {

$ ('a').hover (
  function () {
    var h = $ (this).attr ('href')
    if (h && (h != '#') && (!h.match(/^javascript\:/))) {
      $ ('a[href="' + $ (this).attr ('href') + '"]').addClass ('hover')
    }
  },
  function () {
    $ ('a').removeClass ('hover')
  }
)

})
