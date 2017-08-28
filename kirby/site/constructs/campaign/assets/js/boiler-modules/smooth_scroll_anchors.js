
var SmoothScrollAnchors = (function($, window, document, undefined) {

  function handleAnchorClicks(that, offset, speed) {
    offset = offset || 0;
    speed = speed || 500;

    if (location.pathname.replace(/^\//,'') == that.pathname.replace(/^\//,'') && location.hostname == that.hostname) {
      var target = $(that.hash);

      target = target.length ? target : $('[name=' + that.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top + offset
        }, speed, 'easeInOutExpo');
        return false;
      }
    }
  }

  function init() {
    $('a[href*="#"]:not([href="#"])').click(function(e) {
      e.preventDefault();
      handleAnchorClicks(this);
    });
  }

  // EventEmitter listen for apps window-load
  ee.addListener('window-load', init);

  // Public API
  return {
    init: init
  };

})(jQuery, window, document);



