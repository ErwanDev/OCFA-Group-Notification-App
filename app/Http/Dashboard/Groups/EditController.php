<?php

namespace App\Http\Dashboard\Groups;

use App\Http\Container;
use App\Domain\Contact;
use App\Domain\Group;
use Respect\Validation\Validator as v;

class EditController extends Container
{
	public function get($request, $response, $args)
	{
		$group = Group::find($args['id']);

		if (! $group) {
			return back();
		}

		return $this->render('dashboard.groups.edit', [
			'group' => $group,
			'contacts' => Contact::all(),
		]);
	}

	public function post($request, $response, $args)
	{
		$group = Group::find($args['id']);

		if (! $group) {
			return back();
		}

		$validation = $this->validator->validate($request, [
			'name' => v::notEmpty(),
		]);

		if ($validation->failed()) {
			return back();
		}

		$group->update([
			'name' => $request->getParam('name'),
		]);

		$group->contacts()->sync($request->getParam('contacts'));

		flash('success', 'Group saved!');

		return redirect(
			$this->router->pathFor('dashboard.groups.home')
		);
	}
}