<?php
	echo '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach($pages as $page): foreach ($languages as $lang): if ($page->content($lang->code())->exists()): ?>
	<?php snippet('xml-sitemap-item', ['page' => $page, 'lang' => $lang, 'languages' => $languages]); ?>
<?php endif; endforeach; endforeach; ?>
</urlset>
