<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $fillable = ['name'];

	public function subject() {
		return $this->belongsTo('\App\Models\Subject');
	}

	public function slide() {
		return $this->belongsTo('\App\Models\Slide');
	}
}
