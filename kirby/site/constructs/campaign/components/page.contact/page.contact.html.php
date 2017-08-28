<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<section id="subpage" class="section-subpage">

	<div class="container">

		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
				<a class="icon-link icon-left" href="<?php echo s::get('backUrl', $site->defaultLandingpage()->toUrl()); ?>">
					<?php echo l::get('back') ?>
				</a><!-- /.icon-link icon-left -->
			</div><!-- /.col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
		</div><!-- /.row -->

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

				<?php snippet('constructs/campaign/contact-form') ?>

			</div><!-- /.col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
		</div><!-- /.row -->

	</div><!-- /.container -->

</section><!-- /#subpage .section-subpage -->

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>
