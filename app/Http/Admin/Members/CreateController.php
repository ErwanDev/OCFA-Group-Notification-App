<?php

namespace App\Http\Admin\Members;

use App\Http\Container;
use App\Domain\User;
use Respect\Validation\Validator as v;

class CreateController extends Container
{
	public function get($request, $response, $args)
	{
		return $this->render('admin.members.create');
	}

	public function post($request, $response, $args)
	{
		$validation = $this->validator->validate($request, [
			'name' 		=> v::notEmpty(),
			'email' 	=> v::notEmpty()->email()->emailTaken(),
			'password' 	=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		User::create([
			'name' 		=> $request->getParam('name'),
			'email' 	=> $request->getParam('email'),
			'password' 	=> password_hash($request->getParam('password'), PASSWORD_DEFAULT),
		]);

		flash('success', 'Member added!');
		return redirect(
			$this->router->pathFor('admin.members.home')
		);
	}
}