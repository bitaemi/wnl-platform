<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $fillable = ['name'];

	public function chapter() {
		return $this->belongsTo('\App\Models\Chapter');
	}
}
