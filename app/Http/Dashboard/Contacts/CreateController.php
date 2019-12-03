<?php

namespace App\Http\Dashboard\Contacts;

use App\Http\Container;
use App\Domain\Contact;
use Respect\Validation\Validator as v;

class CreateController extends Container
{
	public function get($request, $response)
	{
		return $this->render('dashboard.contacts.create');
	}

	public function post($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'name' 			=> v::notEmpty(),
			'email' 		=> v::notEmpty()->email(),
			'phone' 		=> v::notEmpty(),
			'preference' 	=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		Contact::create([
			'name' 			=> $request->getParam('name'),
			'email' 		=> $request->getParam('email'),
			'phone' 		=> $request->getParam('phone'),
			'preference' 	=> $request->getParam('preference'),
		]);

		flash('success', 'Contact added!');

		return redirect(
			$this->router->pathFor('dashboard.contacts.home')
		);
	}
}