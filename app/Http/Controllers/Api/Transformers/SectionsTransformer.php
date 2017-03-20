<?php


namespace App\Http\Controllers\Api\Transformers;


use App\Models\Lesson;
use App\Models\Section;
use App\Models\Screen;
use League\Fractal\TransformerAbstract;

class SectionsTransformer extends TransformerAbstract
{
	protected $availableIncludes = [];

	public function transform(Section $section)
	{
		$screenFirstSlide = $section->screen->slides->first();
		$sectionFirstSlide = $section->slides->first();

		$data = [
			'id'       => $section->id,
			'name'     => $section->name,
			'lessons'  => $section->screen->lesson_id,
			'groups'   => $section->screen->lesson->group->id,
			'editions' => $section->screen->lesson->group->course->id,
			'screens'  => $section->screen_id,
		];

		if ($sectionFirstSlide && $screenFirstSlide) {
			$data['slide'] = $sectionFirstSlide->id - $screenFirstSlide->id + 1;
		}

		return $data;
	}

}
