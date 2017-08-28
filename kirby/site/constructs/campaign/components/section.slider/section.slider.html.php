
<div class="slick-slider">

	<?php foreach($page->slides()->toStructure() as $slide): ?>
	  <div class="slick-slide">

			<div class="slick-image-wrapper">

				<?php if($slide->image()->toFile()): ?>
					<?php echo $slide->image()->responsive('slick-slider-image', ['class' => ['hidden-lg-up'], 'data-parent' => '.slick-slide']); ?>
				<?php endif ?>

				<div class='prev-inline-btn-slick'></div><!-- /.prev-inline-btn-slick -->
				<div class='next-inline-btn-slick'></div><!-- /.next-inline-btn-slick -->

			</div><!-- /.slick-image-wrapper -->

			<div class="container slick-slide-content-wrapper">
				<div class="row slick-slide-content <?php echo $slide->layout(); ?>">

					<?php if ($slide->headline()->isNotEmpty()): ?>
						<h3><?php echo $slide->headline()->html(); ?></h3>
					<?php endif ?>

					<?php if ($slide->text()->isNotEmpty()): ?>
						<div class="section-content">
							<?php echo $slide->text()->html(); ?><br />
						</div><!-- /.section-content -->
					<?php endif ?>

				</div><!-- /.row slick-slide-content -->
			</div><!-- /.container slick-slide-content-wrapper -->

	  </div><!-- /.slick-slide -->
	<?php endforeach; ?>

</div><!-- /.slick-slider -->
