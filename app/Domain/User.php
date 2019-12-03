<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $fillable = [
		'name',
		'email',
		'password',
		'is_admin',
	];
}