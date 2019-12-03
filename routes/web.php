<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Group;
use App\Http\Middleware\Guest;
use App\Http\Middleware\Permission;
use App\Http\Middleware\Organization;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\OrganizationHasIT;
use App\Http\Middleware\OrganizationPermission;

$app->get('/', 'App\Http\HomeController')->setName('home');

$app->group('', function () {
	$this->get('/login', 'App\Http\Auth\LoginController:get')->setName('auth.login');
	$this->post('/login', 'App\Http\Auth\LoginController:post');
})->add(new Guest($container));

$app->group('/dashboard', function () use ($container) {
	$this->get('', 'App\Http\Dashboard\HomeController')->setName('dashboard.home');

	$this->group('/account', function () use ($container) {
		$this->get('', 'App\Http\Dashboard\Account\HomeController')->setName('dashboard.account.home');

		$this->get('/details', 'App\Http\Dashboard\Account\DetailsController')->setName('dashboard.account.details');
		$this->post('/details', 'App\Http\Dashboard\Account\DetailsController');

		$this->get('/password', 'App\Http\Dashboard\Account\PasswordController:get')->setName('dashboard.account.password');
		$this->post('/password', 'App\Http\Dashboard\Account\PasswordController:post');
	});

	$this->group('/notifications', function () {
		$this->get('', 'App\Http\Dashboard\Notifications\HomeController')->setName('dashboard.notifications.home');

		$this->get('/create', 'App\Http\Dashboard\Notifications\CreateController:get')->setName('dashboard.notifications.create');
		$this->post('/create', 'App\Http\Dashboard\Notifications\CreateController:post');

		$this->get('/view/{id}', 'App\Http\Dashboard\Notifications\ViewController')->setName('dashboard.notifications.view');

		$this->get('/delete/{id}', 'App\Http\Dashboard\Notifications\DeleteController')->setName('dashboard.notifications.delete');
	});

	$this->group('/groups', function () {
		$this->get('', 'App\Http\Dashboard\Groups\HomeController')->setName('dashboard.groups.home');

		$this->get('/create', 'App\Http\Dashboard\Groups\CreateController:get')->setName('dashboard.groups.create');
		$this->post('/create', 'App\Http\Dashboard\Groups\CreateController:post');

		$this->get('/edit/{id}', 'App\Http\Dashboard\Groups\EditController:get')->setName('dashboard.groups.edit');
		$this->post('/edit/{id}', 'App\Http\Dashboard\Groups\EditController:post');

		$this->get('/delete/{id}', 'App\Http\Dashboard\Groups\DeleteController')->setName('dashboard.groups.delete');
	});

	$this->group('/contacts', function () {
		$this->get('', 'App\Http\Dashboard\Contacts\HomeController')->setName('dashboard.contacts.home');
		
		$this->get('/create', 'App\Http\Dashboard\Contacts\CreateController:get')->setName('dashboard.contacts.create');
		$this->post('/create', 'App\Http\Dashboard\Contacts\CreateController:post');

		$this->get('/edit/{id}', 'App\Http\Dashboard\Contacts\EditController:get')->setName('dashboard.contacts.edit');
		$this->post('/edit/{id}', 'App\Http\Dashboard\Contacts\EditController:post');

		$this->get('/delete/{id}', 'App\Http\Dashboard\Contacts\DeleteController')->setName('dashboard.contacts.delete');
	});

	$this->get('/logout', 'App\Http\Auth\LogoutController')->setName('auth.logout');
})->add(new Authenticated($container));

$app->group('/admin', function () use ($container) {
	$this->get('', 'App\Http\Admin\HomeController')->setName('admin.home');

	$this->group('/members', function () use ($container) {
		$this->get('', 'App\Http\Admin\Members\HomeController')->setName('admin.members.home');

		$this->get('/create', 'App\Http\Admin\Members\CreateController:get')->setName('admin.members.create');
		$this->post('/create', 'App\Http\Admin\Members\CreateController:post');

		$this->get('/delete/{id}', 'App\Http\Admin\Members\DeleteController')->setName('admin.members.delete');
	});
})->add(new Admin($container));