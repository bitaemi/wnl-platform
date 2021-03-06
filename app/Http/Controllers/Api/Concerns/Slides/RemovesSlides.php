<?php

namespace App\Http\Controllers\Api\Concerns\Slides;

use App\Models\Presentable;
use DB;

trait RemovesSlides
{
	/**
	 * Decrements order no. of all slides above the submitted order no.
	 *
	 * @param $presentables
	 */
	protected function decrementOrderNumber($presentables)
	{
		foreach ($presentables as $presentable) {
			$type = addslashes($presentable->type);
			DB::statement(implode(' ', [
				"update presentables set order_number = (order_number - 1)",
				"where order_number >= {$presentable->order_number}",
				"and (presentable_type = '{$type}'",
				"and presentable_id = {$presentable->id})",
			]));
		}
	}

	/**
	 * Detach slide from presentables.
	 *
	 * @param $slide
	 * @param $presentables
	 */
	protected function detachSlide($slide, $presentables)
	{
		foreach ($presentables as $presentable) {
			$presentable->slides()->detach($slide);
		}
	}


	/**
	 * Get slides order number.
	 *
	 * @param $slide
	 * @param $presentable
	 *
	 * @return mixed
	 */
	protected function getSlideOrderNumber($slide, $presentable)
	{
		$orderNumber = Presentable::select(['order_number'])
			->where('slide_id', $slide->id)
			->where('presentable_type', get_class($presentable))
			->where('presentable_id', $presentable->id)
			->first();

		if (is_null($orderNumber)) {
			return null;
		}
		return $orderNumber->order_number;
	}
}
