<?php

namespace App\Http\Dashboard\Notifications;

use App\Http\Container;
use App\Domain\Notification;

class ViewController extends Container
{
	public function __invoke($request, $response, $args)
	{
		$notification = Notification::find($args['id']);

		if (! $notification) {
			return back();
		}

		return $this->render('dashboard.notifications.view', [
			'notification' => $notification,
		]);
	}
}