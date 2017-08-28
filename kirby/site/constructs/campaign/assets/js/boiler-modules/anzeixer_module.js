//////////////////
// Anzeixer Module
var AnzeixerModule = (function($, window, document, undefined) {

	function init() {
		document.addEventListener('viewchange', function(e){
		  ee.emit('view-change', e.detail.currentView);
		}, false);

		ee.emit('view-change', Anzeixer.getView());
	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);

	// Public API
	return {
		init: init
	};

})(jQuery, window, document);
