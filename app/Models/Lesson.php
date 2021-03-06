<?php

namespace App\Models;

use App\Models\Concerns\Cached;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Lesson extends Model
{
	use Cached;

	protected $fillable = ['name', 'group_id', 'is_required'];

	const USER_LESSON_CACHE_KEY = '%s-%s-%s-user-lesson-access';
	const CACHE_VERSION = 1;

	public function screens()
	{
		return $this->hasMany('\App\Models\Screen');
	}

	public function group()
	{
		return $this->belongsTo('\App\Models\Group');
	}

	public function tags()
	{
		return $this->morphToMany('App\Models\Tag', 'taggable');
	}

	public function getQuestionsAttribute()
	{
		return QnaQuestion::whereHas('tags', function ($query) {
			$query->whereIn('tags.id', $this->tags->keyBy('id')->keys());
		})->get();
	}

	public function isAvailable($user = null, $editionId = 1)
	{
		$user = $user ?? \Auth::user();
		if ($user) {
			$lessonAccess = $this->userLessonAccess($user);
			if (!is_null($lessonAccess) && !is_null($lessonAccess->start_date)) {
				return Carbon::parse($lessonAccess->start_date)->isPast();
			}
		}

		return false;
	}

	public function isAccessible($user = null, $editionId = 1)
	{
		$user = $user ?? \Auth::user();
		if ($user) {
			$lessonAccess = $this->userLessonAccess($user);
			return !is_null($lessonAccess);
		}

		return false;
	}

	public function startDate($user = null, $editionId = 1)
	{
		$user = $user ?? \Auth::user();
		if ($user) {
			$lessonAccess = $this->userLessonAccess($user);

			if (!is_null($lessonAccess)) {
				return Carbon::parse($lessonAccess->start_date);
			}
		}

		return null;
	}

	public function userLessonAccess(User $user) {
		return DB::table('user_lesson')
			->where('lesson_id', $this->id)
			->where('user_id', $user->id)
			->first();
	}
}
