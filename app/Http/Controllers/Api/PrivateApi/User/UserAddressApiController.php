<?php namespace App\Http\Controllers\Api\PrivateApi\User;

use Auth;
use App\Models\User;
use League\Fractal\Resource\Item;
use App\Http\Requests\User\UpdateUserAddress;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Transformers\UserAddressTransformer;

class UserAddressApiController extends ApiController
{
	public function get($id)
	{
		$user = User::fetch($id);
		$address = $user->address()->first();

		if (!$user || !$address) {
			return $this->respondNotFound();
		}

		if (!Auth::user()->can('view', $address)) {
			return $this->respondUnauthorized();
		}

		$resource = new Item($address, new UserAddressTransformer, 'user_address');
		$data = $this->fractal->createData($resource)->toArray();

		return $this->respondOk($data);
	}

	public function put(UpdateUserAddress $request)
	{
		$user = User::fetch($request->route('id'));
		$user->address()->updateOrCreate(['user_id' => $user->id], $request->all());

		return $this->respondOk();
	}
}
