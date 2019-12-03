<?php

namespace App\Http\Dashboard\Contacts;

use App\Http\Container;
use App\Domain\Contact;
use Respect\Validation\Validator as v;

class DeleteController extends Container
{
	public function __invoke($request, $response, $args)
	{
		$contact = Contact::find($args['id']);

		if (! $contact) {
			return back();
		}

		$contact->groups()->sync([]);
		$contact->delete();

		return back();
	}
}