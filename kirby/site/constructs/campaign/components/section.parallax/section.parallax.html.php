
<?php echo $page->sectionImage()->responsive('slick-slider-image', ['class' => ['hidden-lg-up'], 'data-parent' => '.section-parallax']); ?>

<div class="container parallax-content-wrapper">
	<div class="row parallax-content <?php echo $page->layout(); ?>">

		<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
			<h3><?php echo $page->sectionHeadline()->html(); ?></h3>
		<?php endif ?>

		<?php if ($page->sectionContent()->isNotEmpty()): ?>
			<div class="section-content">
				<?php echo $page->sectionContent()->kirbytext(); ?>
			</div><!-- /.section-content -->
		<?php endif; ?>

	</div><!-- /.row parallax-content -->
</div><!-- /.container parallax-content-wrapper -->

