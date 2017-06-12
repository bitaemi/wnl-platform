<?php

namespace App\Providers;

use App\Models\ChatRoom;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\QnaAnswer;
use App\Models\QnaQuestion;
use App\Models\Screen;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserBillingData;
use App\Models\UserProfile;
use App\Models\UserSettings;
use App\Policies\Chat\ChatRoomPolicy;
use App\Policies\CommentPolicy;
use App\Policies\Course\ScreensPolicy;
use App\Policies\Qna\QnaAnswerPolicy;
use App\Policies\Qna\QnaQuestionPolicy;
use App\Policies\User\UserAddressPolicy;
use App\Policies\User\UserProfilePolicy;
use App\Policies\User\UserBillingPolicy;
use App\Policies\User\UserSettingsPolicy;
use App\Policies\User\UserPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		User::class            => UserPolicy::class,
		UserProfile::class     => UserProfilePolicy::class,
		UserAddress::class     => UserAddressPolicy::class,
		UserBillingData::class => UserBillingPolicy::class,
		UserSettings::class    => UserSettingsPolicy::class,
		QnaAnswer::class       => QnaAnswerPolicy::class,
		QnaQuestion::class     => QnaQuestionPolicy::class,
		Comment::class         => CommentPolicy::class,
		Screen::class          => ScreensPolicy::class,
		ChatRoom::class        => ChatRoomPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
	}
}
