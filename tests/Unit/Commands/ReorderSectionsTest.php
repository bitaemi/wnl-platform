<?php
namespace Tests\Unit;

use App\Models\Presentable;
use App\Models\Screen;
use App\Models\Section;
use App\Models\Slide;
use App\Models\Slideshow;
use App\Models\Subsection;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReorderSectionsTest extends TestCase
{
	use DatabaseTransactions;

	public function testSlidesInCorrectOrder()
	{
		list ($screen, $sections) = $this->setupDb();

		$slideshow = $screen->slideshow;
		$sectionsNewOrder = collect([$sections->get(1), $sections->get(2), $sections->get(0)]);
		$sectionIds = $sectionsNewOrder->pluck('id')->toArray();

		Artisan::call('sections:reorder', [
			'--screen' => $screen->id,
			'sections' => $sectionIds
		]);

		foreach ($sectionIds as $index => $id) {
			$this->assertDatabaseHas('sections', [
				'id' => $id,
				'first_slide' => $index * 10
			]);
		}

		$slidesNewOrder = $sectionsNewOrder->get(0)->slides
			->concat($sectionsNewOrder->get(1)->slides)
			->concat($sectionsNewOrder->get(2)->slides);

		foreach ($slidesNewOrder as $index => $slide) {
			$this->assertDatabaseHas('presentables', [
				['presentable_type', '=', 'App\\Models\\Slideshow'],
				['presentable_id', '=', $slideshow->id],
				['slide_id', '=', $slide->id],
				['order_number', '=', $index]
			]);
		}
	}

	public function testSlidesInCorrectOrderWithSubsections()
	{
		$subsectionsCount = 6;
		$slidesCount = 30;
		$sectionsCount = 3;
		$slidesInSubsection = $slidesCount / $subsectionsCount;
		$slidesInSection = $slidesCount / $sectionsCount;

		list ($screen, $sections) = $this->setupDb($slidesCount, $sectionsCount);

		factory(Subsection::class, 6)->create()
			->each(function($subsection, $index) use ($slidesInSubsection, $sections) {
				$subsection->first_slide = $index * $slidesInSubsection;
				$sectionIndex = (int) floor(($index % 6) / 2);
				$section = $sections->get($sectionIndex);
				$subsection->section()->associate($section);
				$section->subsections()->save($subsection);
			});

		$sectionsNewOrder = collect([$sections->get(1), $sections->get(2), $sections->get(0)]);
		$sectionIds = $sectionsNewOrder->pluck('id')->toArray();

		Artisan::call('sections:reorder', [
			'--screen' => $screen->id,
			'sections' => $sectionIds
		]);

		foreach ($sectionsNewOrder as $index => $section) {
			$this->assertDatabaseHas('sections', [
				'id' => $section->id,
				'first_slide' => $index * $slidesInSection
			]);

			foreach ($section->subsections as $subsectionIndex => $subsection) {
				$this->assertDatabaseHas('subsections', [
					'id' => $subsection->id,
					'first_slide' => ($index * $slidesInSection) + ($subsectionIndex * $slidesInSubsection)
				]);
			}
		}
	}

	public function testSectionsFromDifferentScreens()
	{
		$slidesInSection = 10;

		list ($screenOne, $sectionScreenOne) = $this->setupDb($slidesInSection, 1);
		list ($screenTwo, $sectionScreenTwo) = $this->setupDb($slidesInSection, 1);

		$sectionsNewOrder = collect([$sectionScreenOne->get(0), $sectionScreenTwo->get(0)]);
		$sectionIds = $sectionsNewOrder->pluck('id')->toArray();

		Artisan::call('sections:reorder', [
			'--screen' => $screenTwo->id,
			'sections' => $sectionIds
		]);

		foreach ($sectionsNewOrder as $index => $section) {
			$this->assertDatabaseHas('sections', [
				'id' => $section->id,
				'first_slide' => $index * $slidesInSection
			]);
		}

		$slidesNewOrder = $sectionsNewOrder->get(0)->slides
			->concat($sectionsNewOrder->get(1)->slides);

		foreach ($slidesNewOrder as $index => $slide) {
			$this->assertDatabaseHas('presentables', [
				['presentable_type', '=', 'App\\Models\\Slideshow'],
				['presentable_id', '=', $screenTwo->slideshow->id],
				['slide_id', '=', $slide->id],
				['order_number', '=', $index]
			]);
		}

		$this->assertDatabaseMissing('sections', [
			'id' => $sectionScreenOne->get(0)->id,
			'screen_id' => $screenOne->id
		]);

		foreach ($sectionScreenOne->get(0)->slides as $slide) {
			$this->assertDatabaseMissing('presentables', [
				['presentable_type', '=', 'App\\Models\\Slideshow'],
				['presentable_id', '=', $screenOne->slideshow->id],
				'slide_id' => $slide->id,
			]);
		}

		$this->assertTrue(
			$screenOne->slideshow->slides()->count() === 0,
			"Slides not removed from screen one slideshow"
		);

		$this->assertTrue(
			$screenTwo->slideshow->slides()->count() === 20,
			"Slides not added to screen two slideshow"
		);
	}

	public function testSlideshowsOrderFixed()
	{
		$slidesInSection = 10;

		list ($screenOne, $sectionScreenOne) = $this->setupDb($slidesInSection, 3);
		list ($screenTwo, $sectionScreenTwo) = $this->setupDb($slidesInSection, 1);

		$sectionsNewOrder = collect([$sectionScreenOne->get(1), $sectionScreenTwo->get(0)]);
		$sectionIds = $sectionsNewOrder->pluck('id')->toArray();

		Artisan::call('sections:reorder', [
			'--screen' => $screenTwo->id,
			'sections' => $sectionIds
		]);

		$sortedSlidesScreenOne = $screenOne->slideshow->slides()->orderBy('order_number')->get();

		foreach ($sortedSlidesScreenOne as $index => $slide) {
			$this->assertDatabaseHas('presentables', [
				'presentable_type' => 'App\\Models\\Slideshow',
				'presentable_id' => $screenOne->slideshow->id,
				'slide_id' => $slide->id,
				'order_number' => $index
			]);
		}

		$sortedSlidesScreenTwo = $screenTwo->slideshow->slides()->orderBy('order_number')->get();

		foreach ($sortedSlidesScreenTwo as $index => $slide) {
			$this->assertDatabaseHas('presentables', [
				'presentable_type' => 'App\\Models\\Slideshow',
				'presentable_id' => $screenTwo->slideshow->id,
				'slide_id' => $slide->id,
				'order_number' => $index
			]);
		}
	}

	public function testSectionsFirstSlideFixed()
	{
		$slidesCount = 30;
		list ($screenOne, $sectionScreenOne) = $this->setupDb($slidesCount, 3);
		list ($screenTwo, $sectionScreenTwo) = $this->setupDb($slidesCount, 1);

		$screenOneSlidesInSection = 10;
		$sectionsNewOrder = collect([$sectionScreenOne->get(1), $sectionScreenTwo->get(0)]);
		$sectionIds = $sectionsNewOrder->pluck('id')->toArray();

		Artisan::call('sections:reorder', [
			'--screen' => $screenTwo->id,
			'sections' => $sectionIds
		]);

		foreach ([$sectionScreenOne->get(0), $sectionScreenOne->get(2)] as $index => $section) {
			$this->assertDatabaseHas('sections', [
				'id' => $section->id,
				'first_slide' => $index * $screenOneSlidesInSection
			]);
		}

		foreach ([$sectionScreenOne->get(1), $sectionScreenTwo->get(0)] as $index => $section) {
			$this->assertDatabaseHas('sections', [
				'id' => $section->id,
				'first_slide' => $index * $screenOneSlidesInSection
			]);
		}
	}

	private function setupSlides($slidesCount) {
		return factory(Slide::class, $slidesCount)
			->create();
	}

	private function setupSlideshow($slides) {
		$slideshow = factory(Slideshow::class)->create();
		$slideshow->slides()->attach($slides);

		return $slideshow;
	}

	private function setupScreen($slideshow) {
		return factory(Screen::class)->create([
			'meta' => ["resources" => [["id" => $slideshow->id, "name" => "slideshows"]], "slides_count" => $slideshow->slides->count()],
		]);
	}

	private function setupPresentable($slideshow) {
		Presentable::where([
			['presentable_type', '=', 'App\\Models\\Slideshow'],
			['presentable_id', '=', $slideshow->id],
		])->get()->each(function($presentable, $index) {
			$presentable->order_number = $index;
			$presentable->save();
		});
	}

	private function setupSections($sectionsCount, $screen, $slides, $slidesInSection) {
		return factory(Section::class, $sectionsCount)
			->create()
			->each(function($section, $index) use ($screen, $slides, $slidesInSection) {
				$section->first_slide = $index * $slidesInSection;
				$sectionSlides = $slides->splice(0, $slidesInSection);
				$section->screen()->associate($screen)->save();
				$section->slides()->attach($sectionSlides);
				$section->save();
			});
	}

	private function setupDb($slidesCount=30, $sectionsCount=3) {
		$slides = $this->setupSlides($slidesCount);
		$slideshow = $this->setupSlideshow($slides);
		$this->setupPresentable($slideshow);

		$screen = $this->setupScreen($slideshow);

		$slidesInSection = $slidesCount / $sectionsCount;
		$sections = $this->setupSections($sectionsCount, $screen, $slides, $slidesInSection);

		return [$screen, $sections];
	}
}
