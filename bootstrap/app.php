<?php

use App\Http\Middleware\Errors;
use App\Http\Middleware\Old;
use App\Http\Middleware\Activity;
use Slim\App;

use Respect\Validation\Validator as v;

require __DIR__ . '/../vendor/autoload.php';

$app = new App([
	'settings' => [
		'debug' => true,
		'determineRouteBeforeAppMiddleware' => true,
		'displayErrorDetails' => true
	],
]);

$container = $app->getContainer();

$container['csrf'] = function ($container) {
	return new \Slim\Csrf\Guard;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection(require('config.php'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
	return $capsule;
};

$container['flash'] = function ($container) {
	return new \Slim\Flash\Messages;
};

$container['auth'] = function ($container) {
	return new \App\App\Auth;
};

$container['session'] = function ($container) {
	return $_SESSION;
};

$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
		'cache' => false,
	]);

    $view->addExtension(
        new Slim\Views\TwigExtension(
            $container->get('router'),
            rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/')
        )
    );

    $view->addExtension(
    	new \App\Views\CsrfExtension(
    		$container->get('csrf')
    	)
    );

	$view->getEnvironment()->addGlobal('flash', $container->flash);
	$view->getEnvironment()->addGlobal('auth', $container->auth);
	$view->getEnvironment()->addGlobal('session', $container->session);
	$view->getEnvironment()->addGlobal('back', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/'));

	return $view;
};

$container['validator'] = function ($container) {
	return new \App\Validation\Validator;
};

$app->add(new Errors($container));
$app->add(new Old($container));
$app->add($container->get('csrf'));

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../routes/web.php';