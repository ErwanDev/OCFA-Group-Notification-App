<?php

namespace App\Http\Dashboard\Account;

use App\Http\Container;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('dashboard.account.home');
	}
}