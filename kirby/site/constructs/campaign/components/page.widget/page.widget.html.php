<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<div class="key-visual">
	<?php echo $page->keyVisual()->responsive('slick-slider-image', ['class' => ['hidden-xs-up'], 'data-parent' => '.key-visual']); ?>
</div><!-- /.key-visual -->

<section id="subpage" class="section-subpage">

	<div class="container">

		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">

				<?php if ($page->mainTitle()->isNotEmpty()): ?>
					<h1><?php echo $page->mainTitle()->html(); ?></h1>
				<?php endif ?>

				<?php if ($page->mainHeadline()->isNotEmpty()): ?>
					<div class="subpage-headline">
						<?php echo $page->mainHeadline()->html(); ?>
					</div><!-- /.subpage-headline -->
				<?php endif ?>

				<?php if ($page->mainContent()->isNotEmpty()): ?>
					<?php echo $page->mainContent()->kirbytext(); ?>
				<?php endif ?>

				<?php if ($widget): ?>
					<div class="dds-widget-container" data-name="donation"></div>
				<?php endif; ?>

			</div><!-- /.col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
		</div><!-- /.row -->

	</div><!-- /.container -->

</section><!-- /#subpage .section-subpage -->

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>
