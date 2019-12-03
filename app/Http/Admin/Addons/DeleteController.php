<?php

namespace App\Http\Admin\Addons;

use App\Http\Container;
use App\Domain\Addon;

class DeleteController extends Container
{
	public function __invoke($request, $response, $args)
	{
		$addon = Addon::find($args['id']);

		if (! $addon) {
			return back();
		}

		$addon->delete();
		$addon->organizations()->sync([]);

		return redirect(
			$this->router->pathFor('admin.addons.home')
		);
	}
}