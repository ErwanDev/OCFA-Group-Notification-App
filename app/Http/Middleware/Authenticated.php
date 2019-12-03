<?php

namespace App\Http\Middleware;

use App\Http\Container;

class Authenticated extends Container
{
	public function __invoke($request, $response, $next)
	{
		if (! auth()->check()) {
			flash('info', 'You need to be logged in to access this area.');
			return redirect(
				$this->router->pathFor('auth.login')
			);
		}

		$response = $next($request, $response);
		return $response;
	}
}