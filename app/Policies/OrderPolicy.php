<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

	public function before($user, $ability)
	{
		if ($user->hasRole('admin')) {
			return true;
		}

		return null;
	}

	public function view(User $user, Order $order)
	{
		return $user->id === $order->user_id;
	}

	public function cancel(User $user, Order $order)
	{
		return $user->id === $order->user_id && !$order->paid;
	}
}
