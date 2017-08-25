<?php namespace App\Http\Controllers\Api\Filters\Quiz;


use App\Http\Controllers\Api\Filters\ApiFilter;
use App\Models\UserPlan;
use Carbon\Carbon;

class PlannedFilter extends ApiFilter
{
	protected $expected = ['user_id'];

	public function apply($model)
	{
		$dates = $this->params['list'];
		// currently only one date is supported but model is most likely ready to handle any date
		$supportedDate = Carbon::parse($dates[0]);

		$plan = UserPlan::where('user_id', $this->params['user_id'])->first();
		$questionsForDay = $plan->questionsForDay($supportedDate)->pluck('question_id')->toArray();

		return $model->whereIn('id', $questionsForDay);
	}
}
