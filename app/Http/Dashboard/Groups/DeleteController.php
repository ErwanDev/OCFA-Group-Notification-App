<?php

namespace App\Http\Dashboard\Groups;

use App\Http\Container;
use App\Domain\Group;
use Respect\Validation\Validator as v;

class DeleteController extends Container
{
	public function __invoke($request, $response, $args)
	{
		$group = Group::find($args['id']);

		if (! $group) {
			return back();
		}

		$group->contacts()->sync([]);
		$group->delete();

		flash('success', 'Group deleted!');

		return back();
	}
}