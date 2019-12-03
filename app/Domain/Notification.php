<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $fillable = [
		'user_id',
		'subject',
		'message',
	];

	public function getCountAttribute()
	{
		$count = 0;
		foreach ($this->groups as $group) {
			foreach ($group->contacts as $contact) {
				$count++;
			}
		}
		return $count;
	}

	public function groups()
	{
		return $this->belongsToMany(Group::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}