<?php namespace App\Http\Controllers\Api\Filters\ByTaxonomy;


class SubjectsFilter extends ByTaxonomyFilter
{
	public function count($builder)
	{
		$taxonomyTags = $this->getTaxonomyTags('subjects');
		$tagIds = $taxonomyTags->pluck('tag_id');

		$aggregatedTags = collect(
			$this->fetchAggregation($builder, $tagIds)
		)->keyBy('key'); // :D

		$structure = $this->buildTaxonomyStructure($taxonomyTags, $aggregatedTags);

		return [
			'type'  => 'tags',
			'message' => 'subjects',
			'items' => $structure,
		];
	}
}
