<?php

namespace App\Http\Admin\Addons;

use App\Http\Container;
use App\Domain\Addon;
use Respect\Validation\Validator as v;

class EditController extends Container
{
	public function get($request, $response, $args)
	{
		$addon = Addon::find($args['id']);

		if (! $addon) {
			return back();
		}

		return $this->render('admin.addons.edit', [
			'addon' => $addon,
		]);
	}

	public function post($request, $response, $args)
	{
		$addon = Addon::find($args['id']);

		if (! $addon) {
			return back();
		}
	
		$validation = $this->validator->validate($request, [
			'name' 			=> v::notEmpty(),
			'description' 	=> v::notEmpty(),
			'price' 		=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		$addon->update([
			'name' 			=> $request->getParam('name'),
			'description' 	=> $request->getParam('description'),
			'price' 		=> $request->getParam('price'),
			'is_it' 		=> ! is_null($request->getParam('is_it')) ? '1' : '0',
		]);

		return redirect(
			$this->router->pathFor('admin.addons.home')
		);
	}
}