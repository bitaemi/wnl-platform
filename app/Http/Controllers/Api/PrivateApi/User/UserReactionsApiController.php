<?php namespace App\Http\Controllers\Api\PrivateApi\User;

use App\Http\Controllers\Api\Transformers\ReactableTransformer;
use Auth;
use App\Models\User;
use App\Models\Reaction;
use App\Models\Reactable;
use App\Http\Controllers\Api\ApiController;
use League\Fractal\Resource\Collection;


class UserReactionsApiController extends ApiController
{
	public function getReactions($id, $type = null)
	{
		$user = User::fetch($id);
		if (!$user) {
			return $this->respondNotFound();
		}

		if (Auth::user()->id !== $user->id) {
			return $this->respondUnauthorized();
		}

		$reactablesBuilder = Reactable::where(['user_id' => $user->id]);

		if ($type) {
			$reaction = Reaction::type($type);
			$reactablesBuilder->where('reaction_id', $reaction->id);
		}

		$reactables = $reactablesBuilder->get();

		$resource = new Collection($reactables, new ReactableTransformer, 'user_notifications');
		$data = $this->fractal->createData($resource)->toArray();

		return $this->json(['reactions' => $data]);
	}
}

