<?php

namespace Tests\Api\Comments;

use App\Models\Comment;
use App\Models\QnaAnswer;
use App\Models\QnaQuestion;
use App\Models\Screen;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Api\ApiTestCase;


class CommentsTest extends ApiTestCase
{
	use DatabaseTransactions;

	/** @test */
	public function post_comment()
	{
		QnaAnswer::flushEventListeners();
		QnaQuestion::flushEventListeners();
		Comment::flushEventListeners();

		$user = User::find(1);

		$tag = factory(Tag::class)->create();
		$screen = factory(Screen::class)->create();
		$question = factory(QnaQuestion::class)->create();
		$answer = factory(QnaAnswer::class)->create(['question_id' => $question->id]);
		$question->tags()->attach($tag);
		$screen->tags()->attach($tag);

		$data = [
			'commentable_resource' => config('papi.resources.qna-answers'),
			'commentable_id' => $answer->id,
			'text' => 'Kolekcjonuję antarktyczne drewniane kaczki, gdyby ktoś coś miał, proszę o info na priv. Pozdrawiam.',
		];

		$response = $this
			->actingAs($user)
			->json('POST', $this->url('/comments'), $data);

		$response
			->assertStatus(200)
			->assertJsonStructure(['id', 'text', 'created_at', 'updated_at']);
	}

	/** @test */
	public function search_comments()
	{
		$user = User::find(1);
		$data = [
			'query' => [
				'where' => [
					['commentable_type', 'quiz_question'],
					['id', 'in', [1, 2, 3, 6, 10]],
					['updated_at', '>', '1495033700']
				],
			],
			'order' => [
				'created_at' => 'desc',
				'id'         => 'asc',
			],
			'limit' => [10, 0],
		];

		$response = $this
			->actingAs($user)
			->json('POST', $this->url('/comments/.search'), $data);

		$response
			->assertStatus(200);
	}

	/** @test */
	public function delete_comment()
	{
		Comment::flushEventListeners();

		$user = User::find(1);
		$comment = factory(Comment::class)->create([
			'user_id' => $user->id
		]);

		$response = $this
			->actingAs($user)
			->json('DELETE', $this->url("/comments/{$comment->id}"));

		$response
			->assertStatus(200);
	}

}
