<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	protected $fillable = [
		'error',
		'message',
	];
}