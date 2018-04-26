<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserLesson;

class UpdateLessonsPreset extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'work_load' => 'numeric|nullable',
			'start_date' => 'date|required',
			'end_date' => 'date',
			'work_days' => 'array|required|between:1,7',
			'days_quantity' => 'numeric',
			'preset_active' => 'string',
		];
	}
}
