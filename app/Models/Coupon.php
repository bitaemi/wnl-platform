<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	protected $fillable = ['name', 'code', 'type', 'value', 'expires_at'];

	public function getIsPercentageAttribute()
	{
		return $this->type === 'percentage';
	}
}
