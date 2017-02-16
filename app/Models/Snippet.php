<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
    protected $fillable = ['content', 'type'];

	public function slides() {
		return $this->morphToMany('\App\Models\Slide', 'presentable');
	}

	public function lessons(){
		return $this->belongsToMany('\App\Models\Lesson', 'screens');
	}
}
