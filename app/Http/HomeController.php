<?php

namespace App\Http;

use App\Domain\Server;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('home');
	}
}