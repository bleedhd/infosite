<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<section id="subpage" class="section-subpage">

	<div class="container">

		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
				<a class="icon-link icon-left" href="<?php echo $page->parent()->url() ?>">
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

				<?php foreach($page->groups()->toStructure() as $item): ?>
					<h2><?php  echo $item->sectionHeadline(); ?></h2>

					<?php  $filenames = $item->attachments()->split(','); ?>
					<?php  if(count($filenames) < 2) $filenames = array_pad($filenames, 2, ''); ?>
					<?php  $files = call_user_func_array(array($page->files(), 'find'), $filenames); ?>

					<ul class="downloads-list">
						<?php foreach($files as $file): ?>
							<li>
								<a href="<?php echo $file->url(); ?>" target="_blank">
									<?php echo ($file->title()->isNotEmpty()) ? $file->title() : $file->name(); ?>
									<span class="file-info">( <?php echo $file->extension(); ?> <?php echo $file->niceSize(); ?> )</span>
									<span class="file-text"><?php echo $file->text(); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul><!-- /.downloads-list -->

				<?php endforeach; ?>

			</div><!-- /.col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
		</div><!-- /.row -->

	</div><!-- /.container -->

</section><!-- /#subpage .section-subpage -->

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>
