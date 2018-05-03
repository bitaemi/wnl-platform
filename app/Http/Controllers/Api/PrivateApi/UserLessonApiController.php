<?php namespace App\Http\Controllers\Api\PrivateApi;

use DB;
use App\Http\Controllers\Api\ApiController;
use Carbon\Carbon;
use Cache;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Http\Requests\User\UpdateUserLesson;
use App\Http\Requests\User\UpdateLessonsPreset;
use App\Models\UserCourseProgress;
use App\Models\UserLesson;
use App\Models\User;
use App\Http\Controllers\Api\Transformers\LessonTransformer;
use League\Fractal\Resource\Collection;

class UserLessonApiController extends ApiController
{
	const GROUP_ID_WIECEJ_NIZ_LEK = 2;
	const GROUP_ID_WARSZTATY = 3;
	const GROUP_ID_POWTORKI = 11;
	const GROUP_ID_DODATKI = 15;
	const GROUP_ID_PROBNY_LEK = 14;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->resourceName = config('papi.resources.user-lesson');
	}

	public function put(UpdateUserLesson $request)
	{
		$userId = $request->userId;
		$lessonId = $request->lessonId;

		$userLesson = UserLesson::where([
			'lesson_id' => $lessonId,
			'user_id' => $userId
		])->first();


		if (!$userLesson) {
			return $this->respondNotFound();
		}

		$userLesson->update([
			'start_date' => Carbon::parse($request->input('date')),
		]);

		Cache::tags("user-$userId")->flush();

		return $this->respondOk();
	}

	public function putPlan(UpdateLessonsPreset $request, $userId)
	{
		$user = User::find($userId);
		$profileId = $user->profile->id;
		$workLoad = $request->work_load;
		$workDays = $request->work_days;
		$startDate = Carbon::parse($request->start_date);
		$endDate = Carbon::parse($request->end_date);
		$daysQuantity = $startDate->diffInDaysFiltered(function(Carbon $date) use ($workDays) {
			$dayOfWeekIso = $date->dayOfWeekIso;
			return in_array($dayOfWeekIso, $workDays);
		}, $endDate->addDay());
		$presetActive = $request->preset_active;
		$sortedLessons = $user->lessonsAvailability()
			->orderBy('group_id')
			->orderBy('order_number')
			->get();

		$completeLessons = UserCourseProgress::where('user_id', $profileId)
			->whereNull('section_id')
			->whereNull('screen_id')
			->where('status', 'complete')
			->get()
			->pluck('lesson_id')
			->toArray();

		$sortedCompletedLessons = [];
		$sortedInProgressLessons = [];
		$requiredInProgressLessonsCount = 0;

		foreach ($sortedLessons as $lesson) {
			if (in_array($lesson->id, $completeLessons)) {
				array_push($sortedCompletedLessons, $lesson);
			} else {
				array_push($sortedInProgressLessons, $lesson);
				if ($lesson->is_required === 1) {
					$requiredInProgressLessonsCount++;
				}
			}
		};

		if ($workLoad === 0) {
			$startDate = Carbon::now();
			$lastLessonDate = $startDate;
			foreach ($sortedLessons as $lesson) {
				$lessonId = $lesson->id;
				DB::table('user_lesson')
					->where('lesson_id', $lessonId)
					->update(['start_date' => $startDate]);
			};
		} else {
			foreach ($sortedCompletedLessons as $lesson) {
				$lessonId = $lesson->id;
				DB::table('user_lesson')
					->where('lesson_id', $lessonId)
					->update(['start_date' => Carbon::now()]);
			};

			$lastLessonDate = $this->calculatePlan(
				$requiredInProgressLessonsCount,
				$sortedInProgressLessons,
				$startDate,
				$daysQuantity,
				$workDays,
				$workLoad,
				$presetActive
			);
		}
		$transformedLessons = new Collection ($user->lessonsAvailability, new LessonTransformer, 'lessons');
		$data = $this->fractal->createData($transformedLessons)->toArray();

		return $this->respondOk([
			'lessons' => $data,
			'end_date' => $lastLessonDate->timestamp,
			'end_date_human' => $lastLessonDate
		]);
	}

	private function calculatePlan(
		$requiredInProgressLessonsCount,
		$lessons,
		$startDate,
		$daysQuantity,
		$workDays,
		$workLoad,
		$presetActive
	)
	{
		if ($presetActive === 'dateToDate') {
			$daysExcess = $daysQuantity % $requiredInProgressLessonsCount;
			// dd($daysExcess, $daysQuantity, $requiredInProgressLessonsCount);
			$computedWorkLoad = floor($daysQuantity / $requiredInProgressLessonsCount);
			$lessonWithExtraDay = 0;
		}

		foreach ($lessons as $lesson) {
			$lessonId = $lesson->id;
			$queriedLesson = DB::table('user_lesson')
				->where('lesson_id', $lessonId);
			$groupId = $lesson->group_id;

			if ($groupId === self::GROUP_ID_WIECEJ_NIZ_LEK ||
				$groupId === self::GROUP_ID_WARSZTATY ||
				$groupId === self::GROUP_ID_DODATKI) {
				$queriedLesson->update(['start_date' => Carbon::now()]);
			} else {
				if ($presetActive === 'dateToDate' && $lessonWithExtraDay < $daysExcess) {
					$workLoad = $computedWorkLoad + 1;
					$lessonWithExtraDay++;
				} else if ($presetActive === 'dateToDate' && $lessonWithExtraDay >= $daysExcess) {
					$workLoad = $computedWorkLoad;
				}
				$dayOfWeekIso = $startDate->dayOfWeekIso;
				$isStartDateVariableAvailable = in_array($dayOfWeekIso, $workDays);

				if ($isStartDateVariableAvailable) {
					$queriedLesson
						->update(['start_date' => $startDate]);
				} else {
					while (!$isStartDateVariableAvailable) {
						$startDate->addDays(1);
						$dayOfWeekIso = $startDate->dayOfWeekIso;
						$isStartDateVariableAvailable = in_array($dayOfWeekIso, $workDays);
					}
					$queriedLesson
						->update(['start_date' => $startDate]);
				}
				$endDate = clone($startDate);
				$addedDays = 1;
				$enoughAdded = $addedDays >= $workLoad;
				$isEndDateAvailable = in_array($endDate->dayOfWeekIso, $workDays);
				while (!$isEndDateAvailable || !$enoughAdded) {
					$endDate->addDay();
					$addedDays++;
					$dayOfWeekIso = $endDate->dayOfWeekIso;
					$isEndDateAvailable = in_array($dayOfWeekIso, $workDays);
					$enoughAdded = $addedDays >= $workLoad;
				}
				$startDate = clone($endDate)->addDay();
			}
		}

		$lastLessonStartDate = $startDate->subDay($workLoad);

		$filteredLessons = array_filter($lessons, (function ($lesson) {
			return $lesson->group_id === self::GROUP_ID_POWTORKI;
		}));

		$filteredLessonsIds = array_map(function($lesson){
			return $lesson->id;
		}, $filteredLessons);

		DB::table('user_lesson')
			->whereIn('lesson_id', $filteredLessonsIds)
			->update(['start_date' => $lastLessonStartDate]);

		return $lastLessonStartDate;
	}
}
