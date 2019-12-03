<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	protected $fillable = [
		'name',
		'phone',
		'email',
		'preference',
	];

	public function groups()
	{
		return $this->belongsToMany(Group::class);
	}
}