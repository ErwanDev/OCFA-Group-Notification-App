<?php

namespace App\Validation\Rules;

use App\Domain\User;
use Respect\Validation\Rules\AbstractRule;

class EmailTaken extends AbstractRule
{
	public function validate($input)
	{
		return User::where('email', $input)->count() == 0;
	}
}