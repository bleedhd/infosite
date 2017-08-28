var SelectizeModule = (function($, window, document, undefined) {

  function init() {
    $('.selectize').selectize({
        create: true
        //sortField: 'text'
    });
  }

  // EventEmitter listen for apps init
  ee.addListener('document-ready', init);

  // Public API
  return {
    init: init
  };

})(jQuery, window, document);
