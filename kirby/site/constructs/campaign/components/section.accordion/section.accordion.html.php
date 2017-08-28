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

			<div class="accordion-wrapper">
				<?php foreach($page->items()->toStructure() as $index => $item): ?>
					<div class="accordion-element">
							<div class="accordion-head collapsed" data-toggle="collapse" data-target="#collapseContent<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseExample">
								<?php echo $item->title()->html(); ?>
							</div><!-- /.accordion-head -->
							<div class="accordion-body-wrapper collapse" id="collapseContent<?php echo $index; ?>">
								<div class="accordion-body">
									<?php echo $item->text()->html(); ?>
								</div><!-- /.accordion-body -->
							</div><!-- /.accordion-body-wrapper -->
					</div><!-- /.accordion-element -->
				<?php endforeach; ?>
			</div><!-- /.accordion-wrapper -->

			<?php if ($page->sectionSummaryTitle()->isNotEmpty()): ?>
				<div class="section-summary-title">
					<?php echo $page->sectionSummaryTitle(); ?>
				</div><!-- /.section-summary-title -->
			<?php endif; ?>

			<?php if ($page->sectionSummary()->isNotEmpty()): ?>
				<div class="section-summary">
					<?php echo $page->sectionSummary()->kirbytext(); ?>
				</div><!-- /.section-summary -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->
