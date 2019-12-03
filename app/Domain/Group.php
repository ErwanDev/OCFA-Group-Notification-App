<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $fillable = [
		'name',
	];

	public function contacts()
	{
		return $this->belongsToMany(Contact::class);
	}

	public function notifications()
	{
		return $this->belongsToMany(Notification::class);
	}
}