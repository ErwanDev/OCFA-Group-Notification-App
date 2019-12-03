<?php

namespace App\Http\Dashboard\Account;

use App\Http\Container;
use Respect\Validation\Validator as v;

class PasswordController extends Container
{
	public function get($request, $response)
	{
		return $this->render('dashboard.account.password');
	}

	public function post($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'old_password' => v::notEmpty(),
			'new_password' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		if (! password_verify($request->getParam('old_password'), $this->auth->user()->password)) {
			flash('danger', 'Your current password does not match.');
			return back();
		}

		$this->auth->user()->update([
			'password' => password_hash($request->getParam('new_password'), PASSWORD_DEFAULT),
		]);

		flash('success', 'Password changed.');
		return back();
	}
}