<?php

namespace App\Http\Middleware;

use App\Http\Container;

class Old extends Container
{
	public function __invoke($request, $response, $next)
	{
		$this->view->getEnvironment()->addGlobal('old', isset($_SESSION['old']) ? $_SESSION['old'] : NULL);
		$_SESSION['old'] = $request->getParams();

		$response = $next($request, $response);
		return $response;
	}
}