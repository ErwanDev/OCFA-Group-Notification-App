<?php

use App\Support\HigherOrderTapProxy;

if (! function_exists('tap')) {
	function tap($value, $callback = null)
	{
		if (is_null($callback)) {
			return new HigherOrderTapProxy($value);
		}

		$callback($value);

		return $value;
	}
}

if (! function_exists('str_slug'))
{
	function str_slug($text)
	{
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~-+~', '-', $text);
		$text = trim(strtolower($text), '-');
		$text = preg_replace('~[^-\w]+~', '', $text);
		return (empty($text)) ? 'n-a' : $text;
	}
}

if (! function_exists('base_path'))
{
	function base_path($path = '')
	{
		return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
	}
}

if (! function_exists('auth'))
{
	function auth()
	{
		return new \App\App\Auth;
	}
}

if (! function_exists('app'))
{
	function app($data = null)
	{
		$app = new \Slim\Container;
		return $data ? $app->{$data} : $app;
	}
}

if (! function_exists('redirect'))
{
	function redirect($to)
	{
		return app('response')->withRedirect($to);
	}
}

if (! function_exists('dd'))
{
	function dd($var)
	{
		var_dump($var);
		die();
	}
}

if (! function_exists('back'))
{
	function back()
	{
		return redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/');
	}
}

if (! function_exists('flash'))
{
	function flash($type, $message)
	{
		return (new \Slim\Flash\Messages)->addMessage($type, $message);
	}
}