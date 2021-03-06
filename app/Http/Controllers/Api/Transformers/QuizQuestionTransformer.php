<?php


namespace App\Http\Controllers\Api\Transformers;


use App\Http\Controllers\Api\ApiTransformer;
use App\Models\QuizQuestion;

class QuizQuestionTransformer extends ApiTransformer
{
	protected $availableIncludes = ['quiz_answers', 'comments', 'slides'];
	protected $parent;

	public function __construct($parent = null)
	{
		$this->parent = $parent;
	}

	public function transform(QuizQuestion $quizQuestion)
	{
		$data = [
			'id'             => $quizQuestion->id,
			'text'           => $quizQuestion->text,
			'explanation'    => $quizQuestion->explanation,
			'preserve_order' => $quizQuestion->preserve_order,
			'tags'           => $quizQuestion->tags,
		];

		if ($this->parent) {
			$data = array_merge($data, $this->parent);
		}

		if (self::shouldInclude('reactions')) {
			$data = array_merge($data, ReactionsCountTransformer::transform($quizQuestion));
		}

		return $data;
	}

	public function includeQuizAnswers(QuizQuestion $quizQuestion)
	{
		$answers = $quizQuestion->answers;

		return $this->collection(
			$answers,
			new QuizAnswerTransformer([
				'quiz_questions' => $quizQuestion->id,
			]),
			'quiz_answers'
		);
	}

	public function includeSlides(QuizQuestion $quizQuestion)
	{
		$slides = $quizQuestion->slides;

		return $this->collection($slides, new SlideTransformer([
			'quiz_questions' => $quizQuestion->id
		], true), 'slides');
	}

	public function includeComments(QuizQuestion $quizQuestion)
	{
		$comments = $quizQuestion->comments;

		return $this->collection(
			$comments,
			new CommentTransformer([
				'quiz_questions' => $quizQuestion->id,
			]),
			'comments'
		);
	}
}
