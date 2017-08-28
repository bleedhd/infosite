<!---->
<?php //foreach($page->catchphrasePosition()->toStructure() as $position): ?>
<!--	Breakpoint:--><?php //echo $position->breakpoint(); ?>
<!--	Top:--><?php //echo $position->top(); ?>
<!--	Right:--><?php //echo $position->right(); ?>
<!--	Bottom:--><?php //echo $position->bottom(); ?>
<!--	Left:--><?php //echo $position->left(); ?>
<?php //endforeach; ?>
<?php

return function ($site, $pages, $page) {

	$catchphraseBreakpoints = [];

	foreach($page->catchphrasePosition()->toStructure() as $position) {
		$pos = $position->toArray();
		unset($pos['breakpoint']);

		$pos = array_filter(array_map(function ($field) {
			return $field->isEmpty() ? false : $field->value();
		}, $pos));

		$catchphraseBreakpoints[$position->breakpoint()->value()] = $pos;
	}

//	$catchphraseBreakpoints = [
//		'xl' => [
//			'bottom' => '50px',
//			'left' => '200px',
//		]
//	];

	return compact('catchphraseBreakpoints');
};
