<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as DebugBarServiceProvider;
use Laravel\Tinker\TinkerServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);

		// Send slack notifications when a critical or higher level error occurs
		$monolog = Log::getMonolog();
		$token = env('ERROR_REPORTER_SLACK_TOKEN');
		$chanel = env('ERROR_REPORTER_SLACK_CHANNEL');
		$level = \Monolog\Logger::CRITICAL;
		$slackHandler = new \Monolog\Handler\SlackHandler($token, $chanel, 'Error Reporter', true, null, $level);
		$monolog->pushHandler($slackHandler);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		if (env('APP_TESTING') === true) {
			$this->app->register(DuskServiceProvider::class);
			$this->app->register(DebugBarServiceProvider::class);
			$this->app->register(TinkerServiceProvider::class);
		}
    }
}
