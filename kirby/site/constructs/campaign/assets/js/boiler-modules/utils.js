window.Utils = (function($, window, document, undefined) {

  // Public API
  return {
    replace: function ($context, data) {
    	$context.find('[data-placeholder]').each(function () {
    		var key = $(this).data('placeholder');

    		$(this).text(data[key] || '')
		});
	},
  };

})(jQuery, window, document);
