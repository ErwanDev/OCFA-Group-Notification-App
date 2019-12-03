<?php

namespace App\Http\Admin\Addons;

use App\Http\Container;
use App\Domain\Addon;
use Respect\Validation\Validator as v;

class CreateController extends Container
{
	public function get($request, $response, $args)
	{
		return $this->render('admin.addons.create');
	}

	public function post($request, $response, $args)
	{
		$validation = $this->validator->validate($request, [
			'name' 			=> v::notEmpty(),
			'description' 	=> v::notEmpty(),
			'price' 		=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		Addon::create([
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