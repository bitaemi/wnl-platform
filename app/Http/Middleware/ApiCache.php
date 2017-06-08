<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\Concerns\GeneratesApiResponses;

class ApiCache
{
	use GeneratesApiResponses;

	private $tags;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$tags = $this->getTags($request);
		$key = $request->getRequestUri();

		if ($this->excluded($request)) {
			return $next($request);
		}

		$cached = Cache::tags($tags)->get($key);

		if ($cached !== null) {
			return $this->respondOk($cached);
		}

		$response = $next($request);

		if ($this->responseValid($response)) {
			Cache::tags($tags)->put($key, $response->getData(), 60 * 24);
		}

		return $response;
	}

	protected function responseValid($response)
	{
		return
			$response instanceof JsonResponse &&
			$response->getStatusCode() === 200;
	}

	protected function excluded($request)
	{
		$excludedTags = ['users', 'profiles', 'reactions', 'tags'];

		$methodExcluded = $request->method() !== 'GET';
		$queryExcluded = (bool)array_intersect($excludedTags, $this->getTags($request));
		$urlExcluded = str_is('*current*', $request->getRequestUri());

		return
			$methodExcluded ||
			$queryExcluded ||
			$urlExcluded;
	}

	protected function getTags($request)
	{
		if (!empty($this->tags)) return $this->tags;

		$resource = $request->route()->controller->resourceName;

		$this->tags = ['api', $resource];

		if ($request->has('include')) {
			$this->tags = array_merge($this->tags, explode('.', $request->get('include')));
		}

		return $this->tags;
	}
}