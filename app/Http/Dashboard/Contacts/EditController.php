<?php

namespace App\Http\Dashboard\Contacts;

use App\Http\Container;
use App\Domain\Contact;
use Respect\Validation\Validator as v;

class EditController extends Container
{
	public function get($request, $response, $args)
	{
		$contact = Contact::find($args['id']);

		if (! $contact) {
			return back();
		}

		return $this->render('dashboard.contacts.edit', [
			'contact' => $contact,
		]);
	}

	public function post($request, $response, $args)
	{
		$contact = Contact::find($args['id']);

		if (! $contact) {
			return back();
		}

		$validation = $this->validator->validate($request, [
			'name' 			=> v::notEmpty(),
			'email' 		=> v::notEmpty()->email(),
			'phone' 		=> v::notEmpty(),
			'preference' 	=> v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		$contact->update([
			'name' 			=> $request->getParam('name'),
			'email' 		=> $request->getParam('email'),
			'phone' 		=> $request->getParam('phone'),
			'preference' 	=> $request->getParam('preference'),
		]);

		flash('success', 'Contact saved!');

		return redirect(
			$this->router->pathFor('dashboard.contacts.home')
		);
	}
}