<?php namespace App\Http\Controllers\Api\PrivateApi;

use App\Events\QnaQuestionPosted;
use App\Events\QnaQuestionRemoved;
use App\Events\QnaQuestionRestored;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Transformers\QnaQuestionTransformer;
use App\Http\Requests\Qna\PostQuestion;
use App\Http\Requests\Qna\UpdateQuestion;
use App\Models\QnaQuestion;
use App\Models\Tag;
use Auth;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;

class QnaQuestionsApiController extends ApiController
{
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->resourceName = config('papi.resources.qna-questions');
	}

	public function post(PostQuestion $request)
	{
		$tags = $request->get('tags');
		$text = $request->get('text');
		$context = $request->get('context');
		$user = Auth::user();

		$question = QnaQuestion::create([
			'text'    => $text,
			'user_id' => $user->id,
			'meta'    => ['context' => $context],
		]);

		foreach ($tags as $tag) {
			$question->tags()->attach(
				Tag::firstOrCreate(['id' => $tag])
			);
		}

		event(new QnaQuestionPosted($question, $tags));

		$resource = new Item($question, new QnaQuestionTransformer, $this->resourceName);
		$data = $this->fractal->createData($resource)->toArray();

		return $this->respondOk($data);
	}

	public function put(UpdateQuestion $request)
	{
		$qnaQuestion = QnaQuestion::withTrashed()->find($request->route('id'));

		if (!$qnaQuestion) {
			return $this->respondNotFound();
		}

		$statusResolved = $request->input('resolved');
		if (isset($statusResolved)) {
			if ($statusResolved) {
				$qnaQuestion->delete();
				event(new QnaQuestionRemoved($qnaQuestion, Auth::user()->id, 'resolved'));
			} else {
				$qnaQuestion->restore();
				event(new QnaQuestionRestored($qnaQuestion, Auth::user()->id));
			}
		} else {
			$qnaQuestion->update([
				'text' => $request->input('text'),
			]);
		}

		return $this->respondOk();
	}

	public function context(Request $request)
	{
		$id = $request->get('context');
		$question = QnaQuestion::find($id);
		$data = [];
		$screen = $question->screen;

		if ($screen) {
			$data = [
				'name' => 'screens',
				'params' => [
					'screenId' => $screen->id,
					'lessonId' => $screen->lesson->id,
					'courseId' => $screen->lesson->group->course->id
				]
			];
		}

		$page = $question->page;

		if ($page) {
			$data = [
				'name' => $page->slug,
			];
		}

		if (!$data) {
			return $this->respondNotFound();
		}

		return $this->respondOk($data);
	}
}
