<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
	protected $fillable = ['name', 'group_id'];

	public function screens() {
		return $this->hasMany('\App\Models\Screen');
	}

	public function group()
	{
		return $this->belongsTo('\App\Models\Group');
	}

	public function availability()
	{
		return $this->hasMany('App\Models\LessonAvailability');
	}

	public function isAvailable($editionId)
	{
		$availability = $this->availability->where('edition_id', $editionId)->first();

		if (!is_null($availability)){
			return $availability->start_date->isPast();
		}

		return true;
	}
}
