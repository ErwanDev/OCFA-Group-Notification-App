<?php

namespace App\Http\Dashboard\Groups;

use App\Http\Container;
use App\Domain\Contact;
use App\Domain\Group;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('dashboard.groups.home', [
			'groups' => Group::all(),
		]);
	}
}