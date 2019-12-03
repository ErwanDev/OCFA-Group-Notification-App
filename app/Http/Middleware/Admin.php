<?php

namespace App\Http\Middleware;

use App\Http\Container;

class Admin extends Container
{
	public function __invoke($request, $response, $next)
	{
		if (! auth()->user()->is_admin) {
			flash('info', 'You dont have access to this area.');
			return redirect(
				$this->router->pathFor('dashboard.home')
			);
		}

		$response = $next($request, $response);
		return $response;
	}
}