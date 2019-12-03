<?php

namespace App\Http\Middleware;

use App\Http\Container;

class Guest extends Container
{
	public function __invoke($request, $response, $next)
	{
		if(auth()->check()) {
			flash('info', 'You are already logged in.');
			return redirect(
				$this->router->pathFor('dashboard.home')
			);
		}

		$response = $next($request, $response);
		return $response;
	}
}