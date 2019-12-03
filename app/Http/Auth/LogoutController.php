<?php

namespace App\Http\Auth;

use App\Http\Container;

class LogoutController extends Container
{
	public function __invoke($request, $response)
	{
		auth()->logout();
		flash('info', 'You disconnected from your account.');
		return redirect(
			$this->router->pathFor('home')
		);
	}
}