
<div class="container">
	<div class="row">
		<div class="col-12">

			<?php if ($page->sectionTitle()->isNotEmpty()): ?>
				<h2><?php echo $page->sectionTitle()->html(); ?></h2>
			<?php else: ?>
				<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
					<h3><?php echo $page->sectionHeadline()->html(); ?></h3><!-- /.section-headline -->
				<?php endif; ?>
			<?php endif; ?>

			<?php if ($page->sectionContent()->isNotEmpty()): ?>
				<div class="section-content">
					<?php echo $page->sectionContent()->kirbytext(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->

<div class="container">
	<div class="row justify-content-center">

			<?php if ($page->downloads()->toPage()): ?>
				<?php foreach($page->downloads()->toPage()->files()->filterBy('feature', '==', '1') as $download):	?>
					<div class="col-12 col-sm-12 col-md-4">
						<div data-mh="match-height" class="doc-teaser-box">
							<div class="doc-teaser-box-header">
								<a href="<?php echo $download->url(); ?>" class="doc-icon" target="_blank"></a>
							</div><!-- /.doc-teaser-box-header -->
							<div class="doc-teaser-box-body">

								<?php if ($download->title()->isNotEmpty()): ?>
									<div class="doc-teaser-title">
										<?php echo $download->title()->html(); ?>
									</div><!-- /.doc-teaser-title -->
								<?php endif ?>

								<?php if ($download->text()->isNotEmpty()): ?>
									<div class="doc-teaser-text">
										<?php echo $download->text()->html(); ?>
									</div><!-- /.doc-teaser-text -->
								<?php endif ?>

								<div class="doc-button-wrapper">
									<a class="btn btn-primary" href="<?php echo $download->url(); ?>" target="_blank">
										<?php echo l::get('documents.download.btn.text'); ?>
									</a>
								</div><!-- /.btn-wrapper -->

							</div><!-- /.doc-teaser-box-body -->

						</div><!-- /.doc-teaser-box -->
					</div><!-- /.col-12 col-sm-12 col-md-4 -->
				<?php endforeach; ?>
			<?php endif; ?>

	</div><!-- /.row -->

	<?php if ($page->downloads()->toPage() and $page->linkLabel()->isNotEmpty()): ?>
		<div class="row">
			<div class="col-12">
				<div class="doc-button-wrapper-more">
					<a class="icon-link icon-right" href="<?php echo $page->downloads()->toPage()->url(); ?>">
						<?php echo $page->linkLabel(); ?>
					</a><!-- /.icon-link icon-right -->
				</div><!-- /.col-12 -->
			</div><!-- /.doc-button-wrapper-more -->
		</div><!-- /.row -->
	<?php endif; ?>

</div><!-- /.container -->
