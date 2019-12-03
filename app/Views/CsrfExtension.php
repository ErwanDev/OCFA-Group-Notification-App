<?php

namespace App\Views;

use Slim\Csrf\Guard;

class CsrfExtension extends \Twig_Extension
{
	private $guard;

	public function __construct(Guard $guard)
	{
		$this->guard = $guard;
	}

	public function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('csrf', array($this, 'csrf'))
		];
	}

	public function csrf()
	{
		return '
			<input type="hidden" name="' . $this->guard->getTokenNameKey() . '" value="' . $this->guard->getTokenName() . '">
			<input type="hidden" name="' . $this->guard->getTokenValueKey() . '" value="' . $this->guard->getTokenValue() . '">
		';
	}
}