(function () {
	var Kirby = {
		Constants: <?php echo a::json($constants); ?>,
		extend: function (other) {
			for (var key in other) {
				// Avoid bugs when hasOwnProperty is shadowed
				if (Object.prototype.hasOwnProperty.call(other, key)) {
					this[key] = other[key];
				}
			}
		}
	};

	<?php
		foreach ($utils as $util) {
			echo $util;
		}
	?>

	window.Kirby = Kirby;
})();
