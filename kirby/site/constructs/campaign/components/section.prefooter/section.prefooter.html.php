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
					<?php echo $page->sectionContent(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

			<?php if ($page->links()->isNotEmpty()): ?>
				<div class="btn-wrapper">
					<?php foreach($page->links()->toStructure() as $link): ?>

						<?php if ($link->linkUrlInternal()->isNotEmpty()): ?>
							<a class="btn btn-primary btn-inverted" href="<?php echo $link->linkUrlInternal()->url(); ?>">
								<?php echo $link->linkLabel()->html(); ?>
							</a><!-- /.btn btn-primary -->
						<?php else: ?>
							<?php if ($link->linkUrlExternal()->isNotEmpty()): ?>
								<a class="btn btn-primary btn-inverted" href="<?php echo $link->linkUrlExternal()->url(); ?>" target="_blank">
									<?php echo $link->linkLabel()->html(); ?>
								</a><!-- /.btn btn-primary -->
							<?php endif; ?>
						<?php endif; ?>

					<?php endforeach; ?>
				</div><!-- /.btn-wrapper -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->


