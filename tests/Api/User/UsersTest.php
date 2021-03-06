<?php

namespace Tests\Api\User;

use App\Models\User;
use Tests\Api\ApiTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends ApiTestCase
{
	/** @test */
	public function api_returns_current_user()
	{
		$user = User::find(1);

		$response = $this->actingAs($user)
			->json('GET', 'papi/v1/users/current');

		$response
			->assertStatus(200)
			->assertJson([
				'id' => $user->id,
			]);
	}
}
