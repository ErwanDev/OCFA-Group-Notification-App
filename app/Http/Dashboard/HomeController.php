<?php

namespace App\Http\Dashboard;

use App\Http\Container;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('dashboard.home');
	}
}