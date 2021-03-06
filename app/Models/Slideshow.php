<?php

namespace App\Models;

use App\Models\Concerns\Cached;
use Facades\Lib\Bethink\Bethink;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
	use Cached;

	protected $fillable = ['background'];

	protected $appends = ['background_url'];

	public function slides()
	{
		return $this->morphToMany('\App\Models\Slide', 'presentable');
	}

	public function getBackgroundUrlAttribute()
	{
		return Bethink::getAssetPublicUrl("backgrounds/{$this->background}") ?? null;
	}
}
