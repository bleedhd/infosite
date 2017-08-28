var FloatingFooter = (function($, window) {

	function init() {
		$('[data-float]').each(function () {

			var floater = $(this),
				mode = floater.data('float'),
				target = $(floater.data('float-target'));
			if(target.length) {
				$(window).scroll(function() {
					if ( $(window).scrollTop() > target.offset().top + target.outerHeight() ) {
						floater.fadeIn();
					} else {
						floater.fadeOut();
					}
				});
			}
		});
	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);

	// Public API
	return {
		init: init
	};

})(jQuery, window);
