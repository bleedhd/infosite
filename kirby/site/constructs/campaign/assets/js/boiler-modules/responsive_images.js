////////////////////
// Responsive Images
var ResponsiveImages = (function($, window, document, config) {

	config = $.extend({
		map: {},
		order: ['xs', 'sm', 'md', 'lg'],
	}, config);

	function loadImages(currentViewport) {
		var currentSrc = config.map[currentViewport] || currentViewport, // determine image to get
			breakpointIndex = config.order.indexOf(currentSrc),
			srcAttr = function (breakpoint) { return 'data-src-' + breakpoint; };

		$('body').find('[' + srcAttr(config.order[0]) + ']').each(function (index, element) {
			var img = $(element),
				backgroundTarget = null,
				breakpoint = breakpointIndex,
				newSrc;

			if (img.data('parent')) {
				backgroundTarget = img.parents(img.data('parent')).first();
			} else if (img.data('target')) {
				backgroundTarget = $(img.data('target'));
			}

			while (breakpoint >= 0 && img.attr('data-src-' + config.order[breakpoint]) === undefined) {
				breakpoint--;
			}

			if (breakpoint >= 0) {
				newSrc = img.attr('data-src-' + config.order[breakpoint]);

				if (newSrc !== img.attr('src')) {
					img.attr('src', newSrc);
					if (backgroundTarget !== null) {
						backgroundTarget.css('background-image', 'url("' + newSrc + '")');
					}
				}
			}
		});

		console.log('loaded image srcs for: ' + currentSrc);
	}

	// EventEmitter listen for apps init
	ee.addListener('view-change', loadImages);

	// Public API
	return {
		init: function () {},
		loadImages: loadImages
	};

})(jQuery, window, document, Kirby.Constants.ResponsiveImages);
