<?php

namespace App\Http\Dashboard\Contacts;

use App\Http\Container;
use App\Domain\Contact;

class HomeController extends Container
{
	public function __invoke($request, $response)
	{
		return $this->render('dashboard.contacts.home', [
			'contacts' => Contact::all(),
		]);
	}
}