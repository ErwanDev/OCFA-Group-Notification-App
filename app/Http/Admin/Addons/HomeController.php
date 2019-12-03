<?php

namespace App\Http\Admin\Addons;

use App\Http\Container;
use App\Domain\Addon;

class HomeController extends Container
{
	public function __invoke($request, $response, $args)
	{
		return $this->render('admin.addons.home', [
			'addons' => Addon::all(),
		]);
	}
}