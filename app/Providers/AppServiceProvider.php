<?php
namespace App\Providers;

use App;
use App\Models;
use App\Observers;
use Barryvdh\Debugbar\ServiceProvider as DebugBarServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Laravel\Tinker\TinkerServiceProvider;
use Log;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RavenHandler;
use Monolog\Logger;
use Validator;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerModelObservers();
		$this->registerSentryLogger();
		$this->registerCustomValidators();
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->app->environment('dev', 'testing')) {
			$this->app->register(DuskServiceProvider::class);
		}
		if ($this->app->environment('dev', 'local')) {
			$this->app->register(TinkerServiceProvider::class);
		}
		if (env('DEBUG_BAR') === true) {
			$this->app->register(DebugBarServiceProvider::class);
		}
	}

	public function registerSentryLogger()
	{
		if (!$this->useExternalLogger()) return;

		$level = Logger::INFO;
		$handler = new RavenHandler(new \Raven_Client(env('SENTRY_DSN')), $level);
		$handler->setFormatter(new LineFormatter("%message% %context% %extra%\n"));
		$monolog = Log::getMonolog();
		$monolog->pushHandler($handler);
		$monolog->pushProcessor(function ($record) {
			// record app version
			$record['context']['app_version'] = config('app.version');

			// record the current user
			$user = Auth::user();
			if ($user) {
				$record['context']['user'] = [
					'email' => $user->email,
				];
			}

			return $record;
		});
	}

	public function useExternalLogger()
	{
		return !App::environment(['dev', 'testing']);
	}

	protected function registerModelObservers()
	{
		Models\Order::observe(Observers\OrderObserver::class);
		Models\User::observe(Observers\UserObserver::class);
		Models\Lesson::observe(Observers\LessonObserver::class);
		Models\Notification::observe(Observers\NotificationObserver::class);
		Models\QnaQuestion::observe(Observers\QnaQuestionObserver::class);
		Models\QnaAnswer::observe(Observers\QnaAnswerObserver::class);
		Models\QnaAnswer::observe(Observers\NotificationModelObserver::class);
		Models\QnaQuestion::observe(Observers\NotificationModelObserver::class);
		Models\Comment::observe(Observers\NotificationModelObserver::class);
		Models\Comment::observe(Observers\CommentObserver::class);
		Models\QuizQuestion::observe(Observers\QuizQuestionObserver::class);
		Models\Slide::observe(Observers\SlideObserver::class);
	}

	protected function registerCustomValidators()
	{
		Validator::extend('alpha_spaces', function ($attribute, $value) {
			// Useful for names and surnames - accept letters, spaces and hyphens
			return preg_match('/^[\pL\s-]+$/u', $value);
		});

		Validator::extend('alpha_comas', function ($attribute, $value) {
			// Useful for textareas - accepts letters, comas, dots, spaces and hyphens
			return preg_match('/^[\pL\s-,.]+$/u', $value);
		});
	}
}
