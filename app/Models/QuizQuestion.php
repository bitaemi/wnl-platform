<?php

namespace App\Models;

use App\Models\Concerns\Cached;
use Illuminate\Database\Eloquent\Model;
use ScoutEngines\Elasticsearch\Searchable;

class QuizQuestion extends Model
{
	use Cached, Searchable;

	protected $fillable = ['text', 'explanation', 'preserve_order'];

	protected $casts = [
		'preserve_order' => 'boolean',
	];

	public function answers()
	{
		return $this->hasMany('App\Models\QuizAnswer');
	}

	public function sets()
	{
		return $this->belongsToMany('App\Models\QuizSet');
	}

	public function comments()
	{
		return $this->morphMany('App\Models\Comment', 'commentable');
	}

	public function tags()
	{
		return $this->morphToMany('App\Models\Tag', 'taggable');
	}

	public function reactions()
	{
		return $this->morphToMany('App\Models\Reaction', 'reactable');
	}

	public function userQuizResults()
	{
		return $this->hasMany('App\Models\UserQuizResults');
	}

	public function toSearchableArray()
	{
		$tags = $this->tags->pluck('name')->toArray();

		$data = [
			'id'         => $this->id,
			'text'       => $this->text,
			'created_at' => $this->created_at->timestamp,
			'updated_at' => $this->updated_at->timestamp,
			'tags'       => $tags,
		];

		return $data;
	}
}
