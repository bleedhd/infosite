<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<!-- render all sections -->
<?php foreach ($page->components('sections')->visible() as $section): ?>
	<section id="<?php echo $section->uid() ?>" class="<?php echo preg_replace('/[.]/', '-', $section->intendedTemplate()); ?><?php if($section->sectionColorBg()->isNotEmpty()) {echo ' '.$section->sectionColorBg();} ?><?php if($section->sectionColorFg()->isNotEmpty()) {echo ' '.$section->sectionColorFg();} ?>">
		<?php echo $section->render(); ?>
	</section>
<?php endforeach ?>

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>
