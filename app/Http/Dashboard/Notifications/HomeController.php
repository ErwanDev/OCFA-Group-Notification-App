<?php

namespace App\Http\Dashboard\Notifications;

use App\Http\Container;
use App\Domain\Notification;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('dashboard.notifications.home', [
			'notifications' => Notification::all(),
		]);
	}
}