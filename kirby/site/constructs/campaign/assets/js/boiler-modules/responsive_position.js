var ResponsivePosition = (function($, window, config) {

	var elements = [],
		defaultCss = {
			left: 'auto',
			right: 'auto',
			top: 'auto',
			bottom: 'auto',
		};

	function init() {
		$('[data-presponsive-pos]').each(function () {
			var element = $(this);

			elements.push(element);
		});
	}

	function updatePosition(currentViewport) {
		var breakpoint = config.map[currentViewport] || currentViewport,
			breakpointIndex = config.order.indexOf(breakpoint);

		$.each(elements, function (index, element) {
			var currentBpIndex = breakpointIndex,
				positions = element.data('presponsive-pos');

			while (currentBpIndex >= 0 && positions[config.order[currentBpIndex]] === undefined) {
				currentBpIndex--;
			}

			if (currentBpIndex >= 0) {
				element.css($.extend({}, defaultCss, positions[config.order[currentBpIndex]]))
			}
		});

	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);
	ee.addListener('view-change', updatePosition);

	// Public API
	return {
		init: init
	};

})(jQuery, window, Kirby.Constants.ResponsiveImages);
