
	<?php assets('js')->register(['type' => 'script', 'src' => url('assets/js/' . (c::get('debug') ? 'all.js' : 'all.min.js'))]); ?>
	<?php echo assets('js')->render(); ?>
	</body>
</html>
