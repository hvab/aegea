class ScrollingModule {
  constructor($el) {
    this.$scrollWrapper = $el
    this.$scroll = $el.find('.js-band-scrollable-inner')
    this.$window = $(window)

    this.hasItems = this.$scroll.find('.band-item').length
    if (!this.hasItems) return
    
    this.scrollResize = new ResizeObserver((entries, observer) => {
      this.checkScrollStartIsHide()
      this.checkScrollEndIsHide()
    })

    this.toggleScrollable()
    this.checkActiveElement()

    this.checkScrollStartIsHide()
    this.checkScrollEndIsHide()

    this.bindEvents()
  }

  get isScrollable() {
    return this.$scroll.get(0).scrollWidth > this.$scroll.get(0).offsetWidth
  }

  bindEvents() {
    $(window).on('resize', () => {
      this.toggleScrollable()
      this.checkActiveElement()
    })

    this.$scroll.on('scroll', (event) => {
      var scrollPosition = event.currentTarget.scrollLeft

      this.hasScrollEndedOnTheRight(scrollPosition)
      this.hasScrollEndedOnTheLeft(scrollPosition)
    })

    this.scrollResize.observe(this.$scrollWrapper[0])
  }

  hasScrollEndedOnTheRight(scrollPosition) {
    var elScrollWidth = this.$scroll.get(0).scrollWidth
    var elVisibileWidth = this.$scroll.get(0).offsetWidth
    var $lastEl = this.$scroll.children().last()
    var lastElNonScrollableSpace = parseFloat($lastEl.css('padding-right')) + parseFloat($lastEl.css('margin-right'))
  
    var scrolled = elScrollWidth - lastElNonScrollableSpace - scrollPosition

    if (scrolled <= elVisibileWidth) {
      this.$scrollWrapper.removeClass('has__endHide')
    } else {
      this.$scrollWrapper.addClass('has__endHide')
    }
  }

  hasScrollEndedOnTheLeft(scrollPosition) {
    if (scrollPosition <= 0) {
      this.$scrollWrapper.removeClass('has__startHide')
    } else {
      this.$scrollWrapper.addClass('has__startHide')
    }
  }

  toggleScrollable() {
    this.$scrollWrapper.toggleClass("is__scrollable", this.isScrollable)

    if (!this.isScrollable) this.$scrollWrapper.removeClass('has__startHide has__endHide')
  }

  checkActiveElement() {
    this.$activeElement = this.$scroll.find('.band-item.band-item-current, .band-item.band-item-parent').first()

    if (this.$activeElement.length && this.isScrollable) this.scrollToActiveItem()
  }

  scrollToActiveItem() {
    var GRADIENT_SIZE = 28

    var prevElements = this.$activeElement.prevAll('.band-item').get()
    var activeElOffset = prevElements.reduce((sum, el) => sum + $(el).outerWidth(true), 0)

    var scrollWidth = this.$scroll.width()
    var scrollLeftPosition = this.$scroll.scrollLeft()
    var activeElWidth = this.$activeElement.width()

    var isActiveElFullyVisibleOnLeft = (activeElOffset - GRADIENT_SIZE) >= scrollLeftPosition
    var isActiveElFullyVisibleOnRight = (activeElOffset + activeElWidth + GRADIENT_SIZE) <= (scrollLeftPosition + scrollWidth)
    var isActiveElFullyVisible = isActiveElFullyVisibleOnLeft && isActiveElFullyVisibleOnRight
    
    if (!isActiveElFullyVisible)  this.$scroll.scrollLeft(activeElOffset - scrollWidth / 2 + activeElWidth / 2)
  }

  checkScrollStartIsHide() {
    var $firstEl = this.$scroll.find('nav .band-item').first()
    var firstElLeftOffset = $firstEl.offset().left
    var scrollLeftOffset = this.$scroll.offset().left

    if (firstElLeftOffset < scrollLeftOffset) {
      this.$scrollWrapper.addClass('has__startHide')
    } else {
      this.$scrollWrapper.removeClass('has__startHide')
    }
  }

  checkScrollEndIsHide() {
    var $lastEl = this.$scroll.children().last()
    var lastElRightOffset = Math.round($lastEl.offset().left + $lastEl.outerWidth())
    var scrollRightOffset = Math.ceil(this.$scroll.offset().left + this.$scroll.outerWidth(true))

    if (lastElRightOffset > scrollRightOffset) {
      this.$scrollWrapper.addClass('has__endHide')
    } else {
      this.$scrollWrapper.removeClass('has__endHide')
    }
  }
}

$.fn.scrollingModule = function() {
  $(this).each(function() {
    return new ScrollingModule($(this))
  })
}

function initScrollingModule() {
  $('.js-band-scrollable').scrollingModule()
}

export default initScrollingModule
