
<div class="container">

	<?php if ($page->sectionTitle()->isNotEmpty()): ?>
		<div class="row">
			<div class="col-12">
				<h2><?php echo $page->sectionTitle()->html(); ?></h2>
			</div><!-- /.col-12 -->
		</div><!-- /.row -->
	<?php endif ?>

	<div class="row">
		<div class="col-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'push-lg-6' : ''; ?>">

			<div class="video-item hidden-lg-up embed-responsive embed-responsive-<?php echo $page->videoAspectRatio(); ?>">
				<iframe class="embed-responsive-item" src="<?php echo $page->videoEmbed(); ?>" allowfullscreen></iframe>
			</div><!-- /.video-item -->

			<h3><?php echo $page->sectionHeadline()->html(); ?></h3>

			<?php if ($page->sectionContent()->isNotEmpty()): ?>
				<div class="section-content">
					<?php echo $page->sectionContent()->kirbytext(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

			<?php if ($page->linkUrl()->isNotEmpty() && $page->linkLabel()->isNotEmpty()): ?>
				<a class="icon-link icon-right" href="<?php echo $page->linkUrl()->url(); ?>">
					<?php echo $page->linkLabel()->html(); ?>
				</a><!-- /.icon-link icon-right -->
			<?php endif; ?>

		</div><!-- /.col-12 col-md-6 -->

		<div class="hidden-md-down col-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'pull-lg-6' : ''; ?>">

			<div class="video-item embed-responsive embed-responsive-<?php echo $page->videoAspectRatio(); ?>">
				<iframe class="embed-responsive-item" src="<?php echo $page->videoEmbed(); ?>" allowfullscreen></iframe>
			</div><!-- /.video-item -->

		</div><!-- /.col-12 col-md-6 -->
	</div><!-- /.row -->
</div><!-- /.container -->
