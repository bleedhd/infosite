
/**
 * This is an unmodified version of the data-layer-helper library provided by Google
 * @see https://github.com/google/data-layer-helper
 */
(function(){/*
 jQuery v1.9.1 (c) 2005, 2012
 jQuery Foundation, Inc. jquery.org/license.
 */
	var g=/\[object (Boolean|Number|String|Function|Array|Date|RegExp)\]/;function h(a){return null==a?String(a):(a=g.exec(Object.prototype.toString.call(Object(a))))?a[1].toLowerCase():"object"}function k(a,b){return Object.prototype.hasOwnProperty.call(Object(a),b)}function m(a){if(!a||"object"!=h(a)||a.nodeType||a==a.window)return!1;try{if(a.constructor&&!k(a,"constructor")&&!k(a.constructor.prototype,"isPrototypeOf"))return!1}catch(b){return!1}for(var c in a);return void 0===c||k(a,c)};/*
	 Copyright 2012 Google Inc. All rights reserved. */
	function n(a,b,c){this.b=a;this.f=b||function(){};this.d=!1;this.a={};this.c=[];this.e=p(this);r(this,a,!c);var d=a.push,e=this;a.push=function(){var b=[].slice.call(arguments,0),c=d.apply(a,b);r(e,b);return c}}window.DataLayerHelper=n;n.prototype.get=function(a){var b=this.a;a=a.split(".");for(var c=0;c<a.length;c++){if(void 0===b[a[c]])return;b=b[a[c]]}return b};n.prototype.flatten=function(){this.b.splice(0,this.b.length);this.b[0]={};s(this.a,this.b[0])};
	function r(a,b,c){for(a.c.push.apply(a.c,b);!1===a.d&&0<a.c.length;){b=a.c.shift();if("array"==h(b))a:{var d=b,e=a.a;if("string"==h(d[0])){for(var f=d[0].split("."),u=f.pop(),d=d.slice(1),l=0;l<f.length;l++){if(void 0===e[f[l]])break a;e=e[f[l]]}try{e[u].apply(e,d)}catch(v){}}}else if("function"==typeof b)try{b.call(a.e)}catch(w){}else if(m(b))for(var q in b)s(t(q,b[q]),a.a);else continue;c||(a.d=!0,a.f(a.a,b),a.d=!1)}}
	function p(a){return{set:function(b,c){s(t(b,c),a.a)},get:function(b){return a.get(b)}}}function t(a,b){for(var c={},d=c,e=a.split("."),f=0;f<e.length-1;f++)d=d[e[f]]={};d[e[e.length-1]]=b;return c}function s(a,b){for(var c in a)if(k(a,c)){var d=a[c];"array"==h(d)?("array"==h(b[c])||(b[c]=[]),s(d,b[c])):m(d)?(m(b[c])||(b[c]={}),s(d,b[c])):b[c]=d}};})();


(function ($) {

	/**
	 * The DataLayerApi provides a simple additional API on top of the Google DataLayerHelper
	 * for other behaviors to consume.
	 */
	function DataLayerApi(listener) {
		var that = this;

		that._handlers = {
			'*': [],
			'data': [],
		};

		that._initialized = false;
		that._buffer = [];

		if (window.dataLayer !== undefined) {
			listener = listener || $.proxy(that._listen, that);
			that._dataLayer = new DataLayerHelper(window.dataLayer, listener, true);
		}
	}

	$.extend(DataLayerApi.prototype, {
		/**
		 * Returns the DataLayerHelper object
		 */
		helper: function () {
			return this._dataLayer;
		},
		/**
		 * Proxy function for DataLayerHelper.get
		 */
		get: function (key) {
			return this._dataLayer === undefined ? undefined : this._dataLayer.get(key);
		},
		/**
		 * Proxy function for DataLayerHelper.push
		 */
		push: function (data) {
			return this._dataLayer === undefined ? false : window.dataLayer.push(data);
		},
		/**
		 * Registers an event handler for a specific data layer event. When an event with the given
		 * name passes through the data layer, then it will automatically call the handler with the
		 * `message` which is the complete data layer at this point and `model` the current data
		 * object (event).
		 *
		 * Two special event names are supported:
		 * - '*' matches any event (any data object with { event: '...' })
		 * - 'data' matches any data passing through the data layer, not just events
		 */
		on: function (eventName, handler) {
			var that = this;

			$.each(eventName.split(' '), function (index, value) {
				if (that._handlers[eventName] === undefined) {
					that._handlers[eventName] = [];
				}

				that._handlers[eventName].push(handler);
			});

			if (!that._initialized) {
				// do a "soft replay" of the buffered events
				$.each(that._buffer, function (index, data) {
					that._dispatch(data[0], data[1], handler);
				});
			}
		},
		replay: function (listener) {
			return new DataLayerApi(listener);
		},
		_listen: function (model, message) {
			// console.log('dataLayer event (message, model)', message, model);

			var that = this;

			if (!that._initialized) {
				// until the dataLayer initialization is complete, buffer all events with a _clone_ of the model
				// at the time the event was triggered.
				that._buffer.push([$.extend({}, model), message]);
			}

			that._dispatch(model, message);
		},
		_dispatch: function (model, message, limitHandler) {
			var that = this,
				handlers = [];

			//console.log('dataLayer msg', message);

			if (message.event !== undefined) {
				if (that._handlers[message.event] !== undefined) {
					handlers = handlers.concat(that._handlers[message.event]);
				}

				handlers = handlers.concat(that._handlers['*']);
			}

			handlers = handlers.concat(that._handlers['data']);

			if (limitHandler === undefined) {
				$.each(handlers, function (index, handler) {
					handler(model, message);
				});
			} else if (handlers.indexOf(limitHandler) >= 0) {
				limitHandler(model, message);
			}
		},
	});

	window.GetuDataLayer = new DataLayerApi();

	$(document).ready(function () {
		window.GetuDataLayer._initialized = true;
		window.GetuDataLayer._buffer = [];
		window.GetuDataLayer.push({ event: 'getu-data-layer-loaded' });
	});

})(jQuery);
