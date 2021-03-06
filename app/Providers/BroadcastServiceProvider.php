<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Broadcast::routes();

		require base_path('routes/channels.php');

		/*
		 * Authenticate the user's personal stream channel...
		 */
		Broadcast::channel('stream.{userId}', function ($user, $userId) {
			$requestedUser = User::find($userId);

			return $requestedUser->can('viewMultiple', Notification::class);
		});

		/*
		 * Authenticate the moderators channel...
		 */
		Broadcast::channel('group.moderators', function ($user) {
			return $user->hasRole('moderator');
		});

		/*
		 * Authenticate the user's personal channel...
		 */
		Broadcast::channel('{userId}', function ($user, $userId) {
			$requestedUser = User::find($userId);

			return $requestedUser->can('viewMultiple', Notification::class);
		});
	}
}
