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

			<?php if ($page->socialMediaEmbed()->isNotEmpty()): ?>
				<div class="code-embed">
					<?php echo $page->socialMediaEmbed(); ?>
				</div><!-- /.code-embed -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->
