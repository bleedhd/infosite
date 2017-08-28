(function (Kirby) {
	Kirby.extend({
		WidgetModules: {
			modules: {},
			register: function (name, module) {
				this.modules[name] = module;
			},
			run: function ($, widget, options, config) {
				var that = this;

				$.each(config.modules, function (index, moduleName) {
					if (that.modules[moduleName]) {
						that.modules[moduleName]($, widget, options, config);
					}
				});
			},
		},
	});
})(Kirby);
