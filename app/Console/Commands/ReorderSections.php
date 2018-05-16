<?php

namespace App\Console\Commands;

use App\Models\Presentable;
use App\Models\Screen;
use App\Models\Section;
use Illuminate\Console\Command;

class ReorderSections extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sections:reorder {--screen=} {sections*}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Order screen sections.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$passedScreen = $this->option('screen');
		$passedSections = $this->argument('sections');
		$sectionsInstances = [];

		$screen = Screen::find($passedScreen);

		$sortedSlides = collect();
		$screensToReorder = [];
		$slidesToRemove = []; // screenId => slideId

		foreach ($passedSections as $index => $sectionId) {
			$section = Section::find($sectionId);
			$sectionScreen = $section->screen;
			$sectionSlides = $section->slides;
			$sortedSlides = $sortedSlides->concat($sectionSlides);
			$sectionsInstances[] = $section;

			if ($sectionScreen->id !== $passedScreen) {
				$slidesToRemove[$sectionScreen->id] = $sectionSlides;
				$screensToReorder[] = $sectionScreen;
				$section->screen()->dissociate();
				$section->screen()->associate($passedScreen);
			}

			$section->order_number = $index;
			$section->save();
		}


		foreach ($slidesToRemove as $screenId => $slides) {
			$this->removeSlidesFromScreenSlideshow($screenId, $slides);
		}

		foreach($screensToReorder as $screenToReorder) {
			$this->call('slideshow:resetOrder', ['slideshowId' => $screenToReorder->slideshow->id]);
		}

		$passedScreenPresentables = $this->addSlidesToScreenSlideshow($screen, $sortedSlides);
		$this->setSlidesOrderNumber($passedScreenPresentables, $sortedSlides);

		$this->call('screens:countSlides');
	}

	private function removeSlidesFromScreenSlideshow($screenId, $slides) {
		$screen = Screen::find($screenId);
		$screen->slideshow->slides()->detach($slides->pluck('id'));
		$screenTags = $screen->tags->pluck('id')->toArray();
		\DB::table('taggables')
			->where('taggable_type', 'App\\Models\\Slide')
			->whereIn('taggable_id', $slides->pluck('id')->toArray())
			->whereIn('tag_id', $screenTags)
			->delete();
	}

	private function addSlidesToScreenSlideshow($screen, $slides) {
		$screen->slideshow->slides()->sync($slides->pluck('id'));
		$screenTags = $screen->tags->pluck('id')->toArray();
		foreach ($slides as $slide) {
			$slide->tags()->sync($screenTags);
		}

		return $this->getPresentableForScreen($screen);
	}

	private function getPresentableForScreen($screen) {
		$whereClause = [
			['presentable_type', 'App\\Models\\Slideshow'],
			['presentable_id', '=', (int) $screen->slideshow->id],
		];

		return Presentable::where($whereClause)->get();
	}

	private function setSlidesOrderNumber($presentables, $slides) {
		foreach ($slides as $index => $slide) {
			$presentable = $presentables->first(function($presentable) use ($slide) {
				return $presentable->slide_id === $slide->id;
			});

			$presentable->order_number = $index;
			$presentable->save();
		}
	}
}
