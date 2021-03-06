<?php

use Illuminate\Database\Seeder;

class QnaAnswersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = \Carbon\Carbon::now();
		DB::table('qna_answers')->insert([
			[
				'text'        => 'kto tam?',
				'user_id'     => 2,
				'question_id' => 1,
				'created_at'  => $now,
				'updated_at'  => $now,
			],
			[
				'text'        => 'Lolol ol olo o',
				'user_id'     => 1,
				'question_id' => 1,
				'created_at'  => $now,
				'updated_at'  => $now,
			],
			[
				'text'        => 'Ja',
				'user_id'     => 1,
				'question_id' => 2,
				'created_at'  => $now,
				'updated_at'  => $now,
			],
			[
				'text'        => 'jak kuna rowem',
				'user_id'     => 2,
				'question_id' => 3,
				'created_at'  => $now,
				'updated_at'  => $now,
			],
		]);
	}
}
