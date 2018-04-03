<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $casts = [
		'paid'        => 'boolean',
		'canceled'    => 'boolean',
		'invoice'     => 'boolean',
		'canceled_at' => 'date',
		'paid_amount' => 'float',
	];

	protected $fillable = [
		'user_id', 'session_id', 'product_id', 'method', 'transfer_title', 'external_id', 'canceled', 'canceled_at',
		'paid_amount', 'invoice', 'paid_at',
	];

	protected $guarded = [
		'paid',
	];

	protected $dates = [
		'paid_at',
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
		return $this->belongsTo('App\Models\Coupon');
	}

	public function studyBuddy()
	{
		return $this->hasOne('App\Models\StudyBuddy');
	}

	public function invoices()
	{
		return $this->hasMany('App\Models\Invoice');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function attachCoupon($coupon)
	{
		$this->coupon_id = $coupon->id;
		$this->save();
	}

	public function getTotalWithCouponAttribute()
	{
		$coupon = $this->coupon;

		if (is_null($coupon)) return $this->product->price;

		return $this->product->price - $this->coupon_amount;
	}

	public function getCouponAmountAttribute()
	{
		$coupon = $this->coupon;

		if (is_null($coupon)) return 0;

		if ($coupon->is_percentage) {
			return number_format($coupon->value * $this->product->price / 100, 2, '.', '');
		}

		return $coupon->value;
	}

	public function getInstalmentsAttribute()
	{
		$instalments = [];
		$totalLeft = 0;
		$leftFromPaid = $this->paid_amount;
		$nextPayment = null;
		$now = Carbon::now();
		$paymentDates = [
			Carbon::createFromDate(2018, 05, 15),
			Carbon::createFromDate(2018, 06, 15),
			Carbon::createFromDate(2018, 07, 15),
		];
		$toDistribute = $this->total_with_coupon;
		$allPaid = $this->paid_amount >= $this->total_with_coupon;

		if ($allPaid) {
			return [
				'allPaid'     => true,
				'instalments' => $instalments,
			];
		}

		end($paymentDates);
		$lastKey = key($paymentDates);
		reset($paymentDates);

		for ($i = 0; $i <= $lastKey; $i++) {
			$date = $paymentDates[$i];

			$instalment = ['date' => $paymentDates[$i]];
			$instalment['amount'] = $i === $lastKey ? $toDistribute : 0.5 * $toDistribute;
			$instalment['left'] = $leftFromPaid > $instalment['amount'] ? 0 : $instalment['amount'] - max($leftFromPaid, 0);
			$instalments[] = $instalment;

			$toDistribute = $toDistribute - $instalment['amount'];
			$leftFromPaid = $leftFromPaid - $instalment['amount'];
			if ($nextPayment === null && $instalment['left'] > 0) {
				$nextPayment = [
					'amount' => $instalment['left'],
					'date'   => $date,
				];
			}
			$totalLeft += $instalment['left'];
		}

		return [
			'allPaid'     => false,
			'instalments' => $instalments,
			'nextPayment' => $nextPayment,
			'total'       => $totalLeft,
		];
	}

	public function cancel()
	{
		$this->canceled = true;
		$this->canceled_at = Carbon::now();

		if (!is_null($this->method)) {
			$this->product->quantity++;
			$this->product->save();
		}

		$this->save();
	}
}
