<?php

namespace App\App;

use DateTime;
use App\Domain\User;
use App\Domain\Permission;

class Auth
{
	public function user()
	{
		if ($this->check()) {
			return User::find($_SESSION['user']);
		}

		return false;
	}
	
	public function check()
	{
		return isset($_SESSION['user']);
	}

	public function attempt($email, $password)
	{
		$user = User::where('email', $email)->first();

		if (! $user) {
			return false;
		}

		if (password_verify($password, $user->password)) {
			$_SESSION['user'] = $user->id;
			return true;
		}

		return false;
	}

	public function logout()
	{
		unset($_SESSION['user']);
		unset($_SESSION['organization']);
	}

	public function registerActivity()
	{
		$this->user()->update([
			'last_activity' => \Carbon\Carbon::now(),
		]);
	}

	public function hasPermission($permissionName)
	{
		if ($this->user()->is_admin) {
			return true;
		}

		$permission = Permission::where('name', $permissionName)->first();

		if (! $permission) {
			return false;
		}

		if (! $this->user()->group->permissions->contains($permission->id)) {
			return false;
		}

		return true;
	}

	public function hasOrganizationPermission($permissionName)
	{
		if ($this->user()->is_admin) {
			return true;
		}

		$permissionName = $permissionName . '.' . $_SESSION['organization'];

		$permission = Permission::where('name', $permissionName)->first();

		if (! $permission) {
			return false;
		}

		if (! $this->user()->permissions->contains($permission->id)) {
			return false;
		}

		return true;
	}
}