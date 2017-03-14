<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $casts = [
		'paid' => 'boolean',
	];

	protected $fillable = [
		'user_id', 'session_id', 'product_id', 'method', 'transfer_title', 'external_id',

	];

	protected $guarded = [
		'paid',
	];

	public function scopeRecent($query)
	{
		return $query
			->orderBy('created_at', 'desc')
			->take(1)
			->first();
	}

	public function product()
	{
		return $this->belongsTo('App\Models\Product');
	}

	public function coupon()
	{
		return $this->hasOne('App\Models\Coupon');
	}

	public function attachCoupon($coupon)
	{
		$this->coupon_id = $coupon->id;
		$this->save();
	}

	public function getTotalWithCouponAttribute()
	{
		$coupon = $this->coupon;
		$subtotal = $this->product->price;
		dd($coupon);
		if (is_null($coupon)) return $subtotal;

		if ($coupon->is_percentage) {
			return $subtotal - ($coupon->value * $subtotal / 100);
		}

		return $subtotal - $coupon->value;
	}
}
