// Create instance of Event Emitter for pub/sub
var ee = new EventEmitter();

$(document).ready(function() {
  ee.emitEvent('document-ready');
});

$(window).load(function() {
  ee.emitEvent('window-load');
});

