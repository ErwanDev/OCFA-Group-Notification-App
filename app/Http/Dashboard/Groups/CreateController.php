<?php

namespace App\Http\Dashboard\Groups;

use App\Http\Container;
use App\Domain\Contact;
use App\Domain\Group;
use Respect\Validation\Validator as v;

class CreateController extends Container
{
	public function get($request, $response)
	{
		return $this->render('dashboard.groups.create', [
			'contacts' => Contact::all(),
		]);
	}

	public function post($request, $response)
	{
		$validation = $this->validator->validate($request, [
			'name' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		$group = Group::create([
			'name' => $request->getParam('name'),
		]);

		$group->contacts()->sync($request->getParam('contacts'));

		flash('success', 'Group created!');

		return redirect(
			$this->router->pathFor('dashboard.groups.home')
		);
	}
}