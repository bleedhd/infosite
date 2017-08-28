<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<section id="subpage" class="section-subpage">

	<div class="container">

		<div class="row">
			<div class="col-12">
				<a class="icon-link icon-left" href="<?php echo s::get('backUrl', $site->defaultLandingpage()->toUrl()); ?>">
					<?php echo l::get('back') ?>
				</a><!-- /.icon-link icon-left -->
			</div><!-- /.col-12 -->
		</div><!-- /.row -->

		<div class="row">
			<div class="col-12">

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

			</div><!-- /.col-12 -->
		</div><!-- /.row -->

		<div class="row">
			<div class="col-12">
				<hr class="camp-hr" />
			</div><!-- /.col-12 -->
		</div><!-- /.row -->

		<?php foreach($page->videoItems()->toStructure() as $item): ?>
			<div class="row video-row">
				<div class="col-12 col-lg-6 <?php echo ($item->layout() == 'text-right') ? 'push-lg-6' : ''; ?>">

					<h2 class="video-title">
						<?php echo $item->videoTitle(); ?>
					</h2><!-- /.video-title -->

					<div class="video-description">
						<?php echo $item->videoDescription() ?>
					</div><!-- /.video-description -->

					<div class="video-item hidden-lg-up embed-responsive embed-responsive-<?php echo $item->videoAspectRatio(); ?>">
						<iframe class="embed-responsive-item" src="<?php echo $item->videoEmbed(); ?>" allowfullscreen></iframe>
					</div><!-- /.video-item -->

				</div><!-- /.col-12 col-lg-6 -->
				<div class="hidden-md-down col-12 col-lg-6 <?php echo ($item->layout() == 'text-right') ? 'pull-lg-6' : ''; ?>">

					<div class="video-item embed-responsive embed-responsive-<?php echo $item->videoAspectRatio(); ?>">
						<iframe class="embed-responsive-item" src="<?php echo $item->videoEmbed(); ?>" allowfullscreen></iframe>
					</div><!-- /.video-item -->

				</div><!-- /.col-12 col-lg-6 -->
			</div><!-- /.row video-row -->
		<?php endforeach; ?>

	</div><!-- /.container -->

</section><!-- /#subpage .section-subpage -->

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>

