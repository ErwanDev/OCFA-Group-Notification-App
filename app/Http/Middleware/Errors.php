<?php

namespace App\Http\Middleware;

use App\Http\Container;

class Errors extends Container
{
	public function __invoke($request, $response, $next)
	{
		$this->view->getEnvironment()->addGlobal('errors', isset($_SESSION['errors']) ? $_SESSION['errors'] : NULL);
		unset($_SESSION['errors']);

		$response = $next($request, $response);
		return $response;
	}
}