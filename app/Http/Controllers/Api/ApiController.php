<?php


namespace App\Http\Controllers\Api;

use App\Events\Event;
use App\Http\Controllers\Api\Concerns\GeneratesApiResponses;
use App\Http\Controllers\Api\Concerns\PaginatesResponses;
use App\Http\Controllers\Api\Concerns\PerformsApiSearches;
use App\Http\Controllers\Api\Concerns\ProvidesApiFiltering;
use App\Http\Controllers\Api\Concerns\TranslatesApiQueries;
use App\Http\Controllers\Api\Serializer\ApiJsonSerializer;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ApiController extends Controller
{
	use GeneratesApiResponses,
		TranslatesApiQueries,
		PerformsApiSearches,
		ProvidesApiFiltering,
		PaginatesResponses;

	protected $fractal;
	protected $request;
	public $resourceName;

	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->fractal = new Manager();
		$this->fractal->setRecursionLimit(10);
		$this->fractal->setSerializer(new ApiJsonSerializer());
		if ($this->request->has('include')) {
			$this->fractal->parseIncludes($this->request->get('include'));
			$this->include = $this->request->get('include');
		}
	}

	/**
	 * Get a resource.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function get($id)
	{
		$request = $this->request;
		$modelName = self::getResourceModel($this->resourceName);

		$models = $this->eagerLoadIncludes($modelName);

		if ($id !== 'all') {
			$models = $modelName::find($id);
			if (!$models) {
				return $this->respondNotFound();
			}
		}

		if ($id === 'all' && $request->limit) {
			$data = $this->paginatedResponse($models, $request->limit, $request->page ?? 1);
		} else {
			$data = $this->transform($models);
		}

		return $this->respondOk($data);
	}

	/**
	 * Delete a resource.
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete($id)
	{
		$modelFullName = self::getResourceModel($this->resourceName);
		$modelName = self::getResourcesStudly($this->resourceName);

		$model = $modelFullName::find($id);

		if (!$model) {
			return $this->respondNotFound();
		}

		if (Auth::user()->can('delete', $model)) {
			$model->forceDelete();

			self::dispatchRemovedEvent($model, $modelName);

			return $this->respondOk();
		}

		return $this->respondForbidden();
	}

	/**
	 * Returns a count of all model's records
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function count()
	{
		return $this->respondOk([
			'count' => (self::getResourceModel($this->resourceName))::count(),
		]);
	}

	/**
	 * Get resource model class name.
	 *
	 * @param $resource
	 *
	 * @return string
	 */
	public static function getResourceModel($resource)
	{
		return 'App\Models\\' . self::getResourcesStudly($resource);
	}

	/**
	 * Dispatch event.
	 *
	 * @param $model
	 * @param $resourceName
	 */
	protected static function dispatchRemovedEvent($model, $resourceName)
	{
		$eventClass = Event::getResourceEvent($resourceName, 'removed');

		if (class_exists($eventClass)) {
			event(new $eventClass($model, Auth::user()->id, 'deleted'));
		}
	}

	/**
	 * Get resource transformer name.
	 *
	 * @param $resource
	 *
	 * @return string
	 */
	protected static function getResourceTransformer($resource)
	{
		return 'App\Http\Controllers\Api\Transformers\\' . self::getResourcesStudly($resource) . 'Transformer';
	}

	/**
	 * Convert resource name to a class name.
	 *
	 * @param $resource
	 *
	 * @return string
	 */
	protected static function getResourcesStudly($resource)
	{
		return studly_case(str_singular($resource));
	}

	/**
	 * Determine whether a resource should be included.
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function shouldInclude($name)
	{
		return str_is("*{$name}*", \Request::get('include'));
	}

	/**
	 * Determine which fields should be excluded from response.
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	public static function shouldExclude($name)
	{
		return str_is("*{$name}*", \Request::get('exclude'));
	}

	/**
	 * @param $results
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function transformAndRespond($results)
	{
		$data = $this->transform($results);

		return $this->json($data);
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	protected function transform($data)
	{
		$transformerName = self::getResourceTransformer($this->resourceName);
		if ($data instanceof Model) {
			$resource = new Item($data, new $transformerName, $this->resourceName);
		} else {
			if ($data instanceof Builder) {
				$data = $data->get();
			}
			$resource = new Collection($data, new $transformerName, $this->resourceName);
		}

		$data = $this->fractal->createData($resource)->toArray();

		return $data;
	}

	protected function eagerLoadIncludes(string $model)
	{
		if (empty($this->include)) return $model::select();
		$relationships = [];

		foreach (explode(',', $this->include) as $chain) {
			$confirmedChain = $this->processChain($chain, $model);
			if ($confirmedChain) {
				array_push($relationships, $confirmedChain);
			}
		}

		return $model::with($relationships);
	}

	protected function modelHasMethod(string $model, string $method)
	{
		return method_exists((new $model), $method);
	}

	protected function processChain(string $chain, string $parentModel)
	{
		$resources = explode('.', $chain);
		$depth = count($resources);
		for ($i = 0; $i < $depth; $i++) {
			if ($i === 0) {
				if (!$this->modelHasMethod($parentModel, $resources[$i])) {
					\Log::debug("Relationship {$resources[$i]} does not exist in model {$parentModel}");

					return false;
				}
			} else {
				$model = self::getResourceModel($resources[$i - 1]);
				if (!$this->modelHasMethod($model, $resources[$i])) {
					\Log::debug("Relationship {$resources[$i]} does not exist in model {$model}");

					return false;
				}
			}
		}

		return $chain;
	}
}
