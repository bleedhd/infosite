<?php

return function ($site, $pages, $page) {
	$transaction = \Getunik\Campaign\TransactionInformation::getFromSession();

	return compact('transaction');
};
