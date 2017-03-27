<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $fillable = ['order_id', 'number', 'series', 'external_id'];

	public function getFileNameAttribute()
	{
		return str_slug($this->id) . '.pdf';
	}

	public function getFilePathAttribute()
	{
		return storage_path('app/invoices/' . $this->file_name);
	}

	public function getNumberSluggedAttribute()
	{
		return str_slug($this->full_number);
	}

	public function getFullNumberAttribute()
	{
		return $this->series . '/' . $this->number;
	}

	public function scopeRecent($query)
	{
		return $query
			->orderBy('created_at', 'desc')
			->take(1)
			->first();
	}
}
