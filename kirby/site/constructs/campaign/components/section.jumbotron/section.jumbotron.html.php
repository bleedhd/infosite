
<?php echo $page->sectionImage()->responsive('slick-slider-image', ['class' => ['hidden-lg-up'], 'data-parent' => '.section-jumbotron']); ?>

<div class="container jumbotron-content-wrapper">
	<div class="row jumbotron-content <?php echo $page->layout(); ?>">

		<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
			<h1><?php echo $page->sectionHeadline()->html(); ?></h1>
		<?php endif ?>

		<?php if ($page->sectionContent()->isNotEmpty()): ?>
			<div class="section-content">
				<?php echo $page->sectionContent(); ?>
			</div><!-- /.section-content -->
		<?php endif; ?>

		<?php if ($page->linkLabel()->isNotEmpty() && $page->anchor()->isNotEmpty()): ?>
			<a class="btn btn-primary btn-lg" href="#<?php echo $page->anchor(); ?>">
				<?php echo $page->linkLabel()->html(); ?>
			</a>
		<?php endif ?>

	</div><!-- /.row jumbotron-content -->
</div><!-- /.container jumbotron-content-wrapper -->

<div class="catchphrase" data-presponsive-pos='<?php echo a::json($catchphraseBreakpoints); ?>'>
	<?php if($page->catchphraseImage()->isNotEmpty()): ?>
		<?php echo $page->catchphraseImage()->responsive(); ?><br />
	<?php endif ?>
</div><!-- /.catchphrase -->
