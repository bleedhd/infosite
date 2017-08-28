
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

			<div class="hidden-lg-up">
				<?php echo $page->sectionImage()->responsive(); ?>
			</div><!-- /.hidden-lg-up -->

			<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
				<h3><?php echo $page->sectionHeadline()->html(); ?></h3>
			<?php endif ?>

			<?php if ($page->sectionContent()->isNotEmpty()): ?>
				<div class="section-content">
					<?php echo $page->sectionContent()->kirbytext(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

			<?php if ($page->linkUrlInternal()->isNotEmpty()): ?>
				<a class="btn btn-primary" href="<?php echo $page->linkUrlInternal()->url(); ?>">
					<?php echo $page->linkLabel()->html(); ?>
				</a><!-- /.btn btn-primary -->
			<?php else: ?>
				<?php if ($page->linkUrlExternal()->isNotEmpty()): ?>
					<a class="btn btn-primary" href="<?php echo $page->linkUrlExternal()->url(); ?>" target="_blank">
						<?php echo $page->linkLabel()->html(); ?>
					</a><!-- /.btn btn-primary -->
				<?php endif; ?>
			<?php endif; ?>

		</div><!-- /.col-12 col-md-6 -->

		<div class="hidden-md-down col-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'pull-lg-6' : ''; ?>">

			<?php echo $page->sectionImage()->responsive(); ?>

		</div><!-- /.col-12 col-md-6 -->
	</div><!-- /.row -->
</div><!-- /.container -->
