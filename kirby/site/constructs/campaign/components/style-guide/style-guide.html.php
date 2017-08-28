<?php snippet('html-header') ?>
<?php snippet('constructs/campaign/top-bar') ?>

<section id="subpage" class="section-subpage">

	<div class="container">

		<div class="row">
			<div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">

				<?php if ($page->mainTitle()->isNotEmpty()): ?>
					<h1><?php echo $page->mainTitle()->html(); ?></h1>
				<?php endif ?>

				<ul class="list-unstyled style-guide-nav">
					<li><a href="#colors">Colors</a></li>
					<li><a href="#webfonts">Webfonts</a></li>
					<li><a href="#unordered-list">Unordered list</a></li>
					<li><a href="#buttons">Buttons</a></li>
				</ul>

				<h2 id="colors">Colors</h2>

                <h3>Background Colors</h3>

				<div class="row">
					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-1">
							<div class="color-box-name background-color">BG Color 1</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-1 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-2">
							<div class="color-box-name background-color">BG Color 2</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-2 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-3">
							<div class="color-box-name background-color">BG Color 3</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-3 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-4">
							<div class="color-box-name background-color">BG Color 4</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-4 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-5">
							<div class="color-box-name background-color">BG Color 5</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-5 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box bg-color-6">
							<div class="color-box-name background-color">BG Color 6</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-6 -->
					</div><!-- /.col-12 col-sm-2 -->
				</div><!-- /.row -->

                <h3>Headline and Text Colors</h3>

				<div class="row">
					<div class="col-12 col-sm-2">
						<div class="color-box fg-color-1">
							<div class="color-box-name foreground-color">Color 1</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-1 -->
					</div><!-- /.col-12 col-sm-2 -->

					<div class="col-12 col-sm-2">
						<div class="color-box fg-color-2">
							<div class="color-box-name foreground-color">Color 2</div><!-- /.color-box-name -->
						</div><!-- /.color-box bg-color-2 -->
					</div><!-- /.col-12 col-sm-2 -->
				</div><!-- /.row -->

                <h2 id="webfonts">Webfonts</h2>

				<div class="font-info">
					<h3>$font-a</h3>
                	<div class="font-a-info">Merriweather Regular 400<br />Merriweather Bold 700</div>
					<code>@import url('https://fonts.googleapis.com/css?family=Merriweather:400,700');</code>
				</div><!-- /.font-info -->

				<div class="font-info">
					<h3>$font-b</h3>
					<div class="font-b-info">Open Sans Regular 400<br />Open Sans Semibold 600</div>
					<code>@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600');</code>
				</div><!-- /.font-info -->

				<h2 id="unordered-list">Unordered list</h2>

                <ul class="list-unstyled bullet-points">
                  <li>List item 1 - Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                  <li>List item 2 - Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                  <li>List item 3 - Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                  <li>List item 4 - Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                  <li>List item 5 - Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                </ul>

				<h2 id="buttons">Buttons</h2>

				<row>
					<div class="col-6 buttons-space primary"><button type="button" class="btn btn-primary btn-block">Primary</button></div>
                	<div class="col-6 buttons-space inverted"><button type="button" class="btn btn-primary btn-inverted btn-block">Primary inverted</button></div>
				</row>

			</div><!-- /.col-12 col-sm-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 -->
		</div><!-- /.row -->

	</div><!-- /.container -->

</section><!-- /#subpage .section-subpage -->

<?php snippet('constructs/campaign/footer') ?>
<?php snippet('html-footer') ?>
