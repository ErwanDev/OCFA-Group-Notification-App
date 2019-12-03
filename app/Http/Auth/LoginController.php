<?php

namespace App\Http\Auth;

use App\Http\Container;
use Respect\Validation\Validator as v;

class LoginController extends Container
{
	public function get($request, $response)
	{
		return $this->render('auth.login');
	}

	public function post($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty(),
			'password' => v::notEmpty(),
		]);
		
		if ($validation->failed()) {
			return back();
		}

		if(! auth()->attempt($request->getParam('email'), $request->getParam('password'))) {
			flash('danger', 'Wrong email or password.');
			return back();
		}

		return redirect(
			$this->router->pathFor('dashboard.home')
		);
	}
}