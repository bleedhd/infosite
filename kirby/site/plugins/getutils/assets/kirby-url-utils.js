(function (Kirby) {
	function makeUrl(base) {
		if (base[base.length - 1] === '/') {
			base = base.substr(0, base.length - 1);
		}
		return function(path) { return base + (path && path[0] === '/' ? path : '/' + path) };
	}

	Kirby.extend({
		url: makeUrl(Kirby.Constants.baseUrl),
		pageUrl: makeUrl(Kirby.Constants.langUrl),
	});
})(Kirby);
