<hr />
<div class="container">
	<div class="row">
		<div class="col-12">

			<blockquote>
				&ldquo;<?php echo $page->quote(); ?>&rdquo;
			</blockquote>

			<?php if($image = $page->sectionImage()->toFile()): ?>
				<img class="quote-image" src="<?php echo thumb($image, array(
					'width' => 128,
					'height' => 128,
					'crop' => true,
					'quality' => 100
					))->url(); ?>">
			<?php endif; ?>

			<?php if ($page->quoteAuthor()->isNotEmpty()): ?>
				<div class="quote-author">
					<?php echo $page->quoteAuthor()->html(); ?>
				</div><!-- /.quote-author -->
			<?php endif; ?>

			<?php if ($page->quoteAuthorFunction()->isNotEmpty()): ?>
				<div class="quote-author-function">
					<?php echo $page->quoteAuthorFunction()->html(); ?>
				</div><!-- /.quote-author-function -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->
</div><!-- /.container -->
