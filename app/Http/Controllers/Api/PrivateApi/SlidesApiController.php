<?php namespace App\Http\Controllers\Api\PrivateApi;


use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Concerns\Slides\AddsSlides;
use App\Http\Requests\Course\PostSlide;
use App\Http\Requests\Course\UpdateSlide;
use App\Jobs\SearchImportAll;
use App\Models\Screen;
use App\Models\Slide;
use Illuminate\Http\Request;
use Lib\SlideParser\Parser;

class SlidesApiController extends ApiController
{
	use AddsSlides;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->resourceName = config('papi.resources.slides');
	}

	public function put(UpdateSlide $request)
	{
		$slide = Slide::find($request->route('id'));

		if (!$slide) {
			return $this->respondNotFound();
		}

		$slide->update($request->all());

		return $this->respondOk();
	}

	/**
	 * @param PostSlide $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function post(PostSlide $request)
	{
		$screen = Screen::find($request->screen);
		$content = $request->get('content');
		$slideshow = $screen->slideshow;
		$orderNumber = $request->order_number - 1; // https://goo.gl/ZzMWT3

		$currentSlide = $this->getCurrentFromPresentables($slideshow->id, $orderNumber);
		$presentables = $this->getSlidePresentables($currentSlide, $screen);

		$presentables->push($slideshow);
		$presentables = $this->getPresentablesOrder($currentSlide, $presentables);

		$this->incrementOrderNumber($presentables);

		$parser = new Parser;
		$content = $parser->handleCharts($content);
		$content = $parser->handleImages($content);

		$slide = Slide::create([
			'is_functional' => empty($request->is_functional) ? false : true,
			'content'       => $content,
		]);

		$this->attachSlide($slide, $presentables);

		dispatch(new SearchImportAll('App\\Models\\Slide'));
		\Artisan::queue('screens:countSlides');
		\Artisan::call('cache:tag', ['tag' => 'presentables']);

		return $this->respondOk();
	}
}
