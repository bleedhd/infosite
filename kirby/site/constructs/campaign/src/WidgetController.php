<?php

namespace Getunik\Campaign;

use F;
use GetUtils\DataLayer;
use Response;


class WidgetController
{
	/**
	 * @param string $path
	 *   The path of the requested widget return file.
	 *
	 * @return Response
	 */
	public function widgetCallbackAction($path)
	{
		$assetsPath = kirby()->get('construct', 'widget')->assetsPath();
		$file = implode(DS, [$assetsPath, 'widgets', $path]);

		if (file_exists($file)) {
			return new Response(F::read($file), F::extension($file));
		} else {
			return new Response('The file could not be found', F::extension($file), 404);
		}
	}

	public function paymentSuccessAction()
	{
		$transaction = TransactionInformation::getFromRequest();
		DataLayer::push($transaction->getECommerceTrackingData(true));

		$transaction->storeInSession();

		return Response::json(['status' => 'ok']);
	}
}
