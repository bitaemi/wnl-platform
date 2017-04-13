<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
	protected $fillable = ['text', 'is_correct', 'quiz_question_id'];

	protected $casts = [
		'is_correct' => 'boolean',
	];
}
