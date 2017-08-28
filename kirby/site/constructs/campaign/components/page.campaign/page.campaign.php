<?php

return function ($site, $pages, $page) {
	s::set('backUrl', $page->url());
	return NULL;
};
