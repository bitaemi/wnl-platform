<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'slug'];

	public function groups() {
		return $this->hasMany('\App\Models\Group');
	}
}
