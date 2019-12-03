<?php

namespace App\Http\Dashboard\Notifications;

use App\Http\Container;
use App\Domain\Notification;

class DeleteController extends Container
{
	public function __invoke($request, $response, $args)
	{
		$notification = Notification::find($args['id']);

		if (! $notification) {
			return back();
		}

		$notification->groups()->sync([]);
		$notification->delete();

		flash('success', 'Notification deleted!');

		return back();
	}
}