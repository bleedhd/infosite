
<div class="footer">

	<div class="container">
		<div class="row">
			<div class="col-6">

				<?php if ($kirby->site()->languages()->count() > 1): ?>
					<nav>
					  <ul class="language-navi">
					    <?php foreach($site->languages() as $language): ?>
					    <li<?php e($site->language() == $language, ' class="active"') ?>>
					      <a href="<?php echo $page->url($language->code()) ?>">
					        <?php echo html($language->code()) ?>
					      </a>
					    </li>
					    <?php endforeach ?>
					  </ul><!-- /.language-navi -->
					</nav>
				<?php endif; ?>

			</div><!-- /.col-6 -->
			<div class="col-6">

				<div class="social-media">
					<?php foreach($site->socialIcons()->toStructure() as $item): ?>
						<a class="social-media-link <?php echo $item->platform(); ?>" href="<?php echo $item->linkUrl()->url(); ?>" target="_blank">
							<?php echo $item->platform(); ?>
						</a>
					<?php endforeach; ?>
				</div><!-- /.social-media -->

			</div><!-- /.col-6 -->
		</div><!-- /.row -->
	</div><!-- /.container -->

	<div class="container">

		<?php if ($kirby->site()->languages()->count() > 1 || $site->socialIcons()->toStructure()->count() > 0): ?>
			<hr />
		<?php endif ?>

		<div class="row">
			<div class="col-12 col-md-3">
				<?php echo $site->leftColumn()->kirbytext(); ?>
			</div><!-- /.col-12 col-md-3 -->
			<div class="col-12 col-md-3">
				<?php echo $site->centerColumn()->kirbytext(); ?>
			</div><!-- /.col-12 col-md-3 -->
			<div class="col-12 col-md-6">
				<ul class="list-unstyled right-column-links">
					<?php foreach($site->rightColumn()->toStructure() as $link): ?>

						<?php if ($link->linkUrlInternal()->isNotEmpty()): ?>
							<li>
								<a href="<?php echo $link->linkUrlInternal()->url(); ?>">
									<?php echo $link->linkLabel()->html(); ?>
								</a>
							</li>
						<?php else: ?>
							<?php if ($link->linkUrlExternal()->isNotEmpty()): ?>
								<li>
									<a href="<?php echo $link->linkUrlExternal()->url(); ?>" target="_blank">
										<?php echo $link->linkLabel()->html(); ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endif; ?>

					<?php endforeach; ?>
				</ul>
			</div><!-- /.col-12 col-md-6 -->
		</div><!-- /.row -->

	</div><!-- /.container -->

	<div class="container">
		<hr />

		<div class="row">
			<div class="col-12 col-md-6">
				<?php echo $site->copyright()->html(); ?>
			</div><!-- /.col-12 col-md-6 -->
			<div class="col-12 col-md-6">

		    <?php if($brandImageMobile = $site->footerBrandImageMobile()->toFile()): ?>
		    	<a href="<?php echo $site->footerBrandLinkUrl()->url(); ?>" target="_blank">
					<img class="footer-brand-logo hidden-lg-up" src="<?php echo $brandImageMobile->url(); ?>" />
				</a>
		    <?php endif; ?>

		    <?php if($brandImage = $site->footerBrandImage()->toFile()): ?>
		    	<a href="<?php echo $site->footerBrandLinkUrl()->url(); ?>" target="_blank">
					<img class="footer-brand-logo hidden-md-down" src="<?php echo $brandImage->url(); ?>" />
				</a>
		    <?php endif; ?>

			</div><!-- /.col-12 col-md-6 -->
		</div><!-- /.row -->
	</div><!-- /.container -->

</div><!-- /.footer -->

