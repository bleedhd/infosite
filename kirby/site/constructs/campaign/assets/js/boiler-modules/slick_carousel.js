
var SlickCarouselModule = (function($, window, document, undefined) {

	function init() {

		$('.slick-slider').slick({
			autoplay: false,
			lazyLoad: 'ondemand',
			prevArrow: '<a href="" class="slick-prev"></a>',
			nextArrow: '<a href="" class="slick-next"></a>',
			dots: true,
			speed: 300
		});

		$('.prev-inline-btn-slick').on('click', function(e) {
			event.preventDefault();
			$('.slick-slider').slick('slickPrev');
		});

		$('.next-inline-btn-slick').on('click', function(e) {
			event.preventDefault();
			$('.slick-slider').slick('slickNext');
		});

	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);

	// Public API
	return {
		init: init
	};

})(jQuery, window, document);
