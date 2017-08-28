//////////////////////////
// Full screen start page
var FullscreenJumbo = (function($, window, document, undefined) {

  function init() {
    if (Foundation.MediaQuery.current !== 'small') {
      var contentHeight = $('.ses-jumbotron').outerHeight();
      $('.ses-jumbotron').outerHeight( Math.max($(window).height() - $('.top-bar').outerHeight(), contentHeight) );
    }
  }

  // EventEmitter listen for apps window-load
  ee.addListener('foundation-ready', init);

  // Public API
  return {
    init: init
  };
})(jQuery, window, document);
