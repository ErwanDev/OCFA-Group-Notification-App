<?php

namespace App\Http;

class ContactController extends Container
{
	public function __invoke()
	{
		return $this->render('contact', [
			'tos' => \App\Domain\Setting::where('name', 'tos')->first(),
		]);
	}
}