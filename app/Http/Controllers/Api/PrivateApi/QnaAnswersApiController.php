<?php namespace App\Http\Controllers\Api\PrivateApi;

use App\Http\Controllers\Api\Transformers\QnaAnswerTransformer;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Qna\PostAnswer;
use App\Http\Requests\Qna\UpdateAnswer;
use App\Models\QnaAnswer;
use League\Fractal\Resource\Item;
use Illuminate\Http\Request;
use App\Models\QnaQuestion;
use Auth;

class QnaAnswersApiController extends ApiController
{
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->resourceName = config('papi.resources.qna-answers');
	}

	public function post(PostAnswer $request)
	{
		$questionId = $request->get('question_id');
		$text = $request->get('text');
		$user = Auth::user();

		$question = QnaQuestion::find($questionId);

		if (!$question) {
			return $this->respondNotFound('Question does not exist.');
		}

		$answer = $question->answers()->create([
			'text'    => $text,
			'user_id' => $user->id,
		]);

		$resource = new Item($answer, new QnaAnswerTransformer, $this->resourceName);
		$data = $this->fractal->createData($resource)->toArray();

		return $this->respondOk($data);
	}

	public function put(UpdateAnswer $request)
	{
		$qnaAnswer = QnaAnswer::find($request->route('id'));

		if (!$qnaAnswer) {
			return $this->respondNotFound();
		}

		$qnaAnswer->update([
			'text' => $request->input('text'),
		]);

		return $this->respondOk();
	}
}
