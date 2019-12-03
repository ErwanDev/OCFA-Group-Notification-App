<?php

namespace App\Http\Admin\Members;

use App\Http\Container;
use App\Domain\User;

class HomeController extends Container
{
	public function __invoke($request, $response, $args)
	{
		return $this->render('admin.members.home', [
			'users' => User::all(),
		]);
	}
}