
<?php echo $page->sectionImage()->responsive('slick-slider-image', ['class' => ['hidden-lg-up'], 'data-parent' => '.section-bulletpoints']); ?>

<div class="container">

	<?php if ($page->sectionTitle()->isNotEmpty()): ?>
		<div class="row">
			<div class="col-12">
				<h2><?php echo $page->sectionTitle()->html(); ?></h2>
			</div><!-- /.col-12 -->
		</div><!-- /.row -->
	<?php endif ?>

	<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
		<div class="row">
			<div class="col-12 col-md-12 col-lg-6">
				<h3><?php echo $page->sectionHeadline()->html(); ?></h3>
			</div><!-- /.col-12 col-md-12 col-lg-6 -->
		</div><!-- /.row -->
	<?php endif ?>

	<div class="row">
		<div class="col-12 col-md-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'push-lg-6' : ''; ?>">

			<?php if ($page->sectionContent()->isNotEmpty()): ?>
				<div class="section-content">
					<?php echo $page->sectionContent()->kirbytext(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

			<?php if ($page->items()->isNotEmpty()): ?>
				<ul class="list-unstyled bullet-points hidden-sm-up">
					<?php foreach($page->items()->toStructure() as $item): ?>
						<li><?php echo $item->bulletPoint()->html(); ?></li>
					<?php endforeach; ?>
				</ul><!-- /.bullet-points -->
			<?php endif; ?>

			<?php if ($page->linkUrlInternal()->isNotEmpty()): ?>
				<a class="icon-link icon-right" href="<?php echo $page->linkUrlInternal()->url(); ?>">
					<?php echo $page->linkLabel()->html(); ?>
				</a><!-- /.icon-link icon-right -->
			<?php else: ?>
				<?php if ($page->linkUrlExternal()->isNotEmpty()): ?>
					<a class="icon-link icon-right" href="<?php echo $page->linkUrlExternal()->url(); ?>" target="_blank">
						<?php echo $page->linkLabel()->html(); ?>
					</a><!-- /.icon-link icon-right -->
				<?php endif; ?>
			<?php endif; ?>

		</div><!-- /.col-12 col-md-12 -->

		<div class="col-12 col-md-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'pull-lg-6' : ''; ?>">

			<?php if ($page->items()->isNotEmpty()): ?>
				<ul class="list-unstyled bullet-points hidden-xs-down">
					<?php foreach($page->items()->toStructure() as $item): ?>
						<li><?php echo $item->bulletPoint()->html(); ?></li>
					<?php endforeach; ?>
				</ul><!-- /.bullet-points -->
			<?php endif; ?>

		</div><!-- /.col-12 col-md-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->
