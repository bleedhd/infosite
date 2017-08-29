<url>
	<loc><?php echo $page->url($lang->code()); ?></loc>
	<lastmod><?php echo strftime('%Y-%m-%d', $page->modified()); ?></lastmod>
	<priority><?php echo ($page->isHomePage()) ? 1 : number_format(0.5 / $page->depth(), 2); ?></priority>
<?php foreach ($languages as $alternate): if ($page->content($alternate->code())->exists()): ?>
	<xhtml:link rel="alternate" hreflang="<?php echo $alternate->code(); ?>" href="<?php echo $page->url($alternate->code()); ?>" />
<?php endif; endforeach; ?>
</url>
