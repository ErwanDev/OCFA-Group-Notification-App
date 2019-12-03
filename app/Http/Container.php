<?php

namespace App\Http;

class Container
{
	protected $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function __get($property)
	{
		if ($this->container->{$property}) {
			return $this->container->{$property};
		}
	}

	public function render($path, $data = [])
    {
        return $this->view->render(
            $this->response,
            str_replace('.', '/', $path) . '.twig',
            $data
        );
    }
}