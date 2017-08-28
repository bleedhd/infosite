<div class="navbar-mobile-header-wrapper">
	<div class="container navbar-mobile-header hidden-lg-up">

	    <?php if($brandImageMobile = $site->brandImageMobile()->toFile()): ?>
	    	<a class="navbar-brand" href="<?php echo page('home')->url() ?>">
	            <img src="<?php echo $brandImageMobile->url(); ?>" />
	        </a>
	    <?php endif; ?>

		<?php if ($page->template() == 'page.campaign'): ?>
		  <button class="navbar-toggler navbar-toggleable-md hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
		  </button>
		<?php endif; ?>

	</div><!-- /.container -->
</div><!-- /.navbar-mobile-header-wrapper -->

<div class="top-navi">
	<div class="container">
		<div class="collapse navbar-toggleable-md" id="navbarResponsive">
			<nav>

		    <?php if($brandImage = $site->brandImage()->toFile()): ?>
		    	<a class="navbar-brand hidden-md-down" href="<?php echo page('home')->url() ?>">
                    <img src="<?php echo $brandImage->url(); ?>" />
                </a>
		    <?php endif; ?>

		    <ul class="top-navi-menu">

					<!-- navigation items -->
					<?php foreach ($page->components('sections')->filterBy('navigationTitle', '!=', '') as $item): ?>
			      <li>
			        <a href="#<?php echo $item->uid(); ?>"><?php echo $item->navigationTitle(); ?></a>
			      </li>
					<?php endforeach; ?>

				<?php if ($page->template() == 'page.campaign'): ?>
				    <?php if ($site->externalLinkText()->isNotEmpty()): ?>
							<li class="external-link">
								<a href="<?php echo $site->externalLinkUrl(); ?>" target="_blank"><?php echo $site->externalLinkText(); ?></a>
							</li>
				    <?php endif; ?>
			    <?php endif; ?>

		    </ul><!-- /.top-navi-menu -->

				<?php if ($kirby->site()->languages()->count() > 1): ?>
				  <ul class="language-navi hidden-lg-up">
				    <?php foreach($site->languages() as $language): ?>
				    <li<?php e($site->language() == $language, ' class="active"') ?>>
				      <a href="<?php echo $page->url($language->code()) ?>">
				        <?php echo html($language->code()) ?>
				      </a>
				    </li>
				    <?php endforeach; ?>
				  </ul><!-- /.language-navi -->
				<?php endif; ?>

			</nav>

		</div><!-- /.collapse navbar-toggleable-md -->
	</div><!-- /.container -->
</div><!-- /.top-navi -->
