<?php


namespace App\Observers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\Lesson;
use App\Models\Tag;


class LessonObserver
{
	use DispatchesJobs;


	public function created(Lesson $lesson)
	{

	}

}
