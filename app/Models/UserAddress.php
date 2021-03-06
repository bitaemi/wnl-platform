<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
	protected $fillable = [
		'street',
		'zip',
		'city',
		'phone',
		'recipient',
	];
}
