<?php

namespace App\Exceptions;

use App;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		// Send exceptions to Sentry
		if ($this->reportToSentry($exception)) {
			app('sentry')->captureException($exception, ['extra' => ['app_version' => config('app.version')]]);
		}

		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		$production = App::environment('production');

		if ($exception instanceof TokenMismatchException) {
			return $this->unauthenticated($request);
		}

		if (!$production) {
			return parent::render($request, $exception);
		}

		if ($exception instanceof HttpResponseException) {
			return $exception->getResponse();
		}

		if ($exception instanceof AuthenticationException) {
			return $this->unauthenticated($request);
		}

		if ($exception instanceof ValidationException) {
			return $this->convertValidationExceptionToResponse($exception, $request);
		}

		if ($exception instanceof NotFoundHttpException) {
			return response()->view('errors.404', [], 404);
		}

		if ($exception instanceof ServiceUnavailableHttpException) {
			return response()->view('errors.503', [], 503);
		}

		return response()->view('errors.500', [], 500);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}

	public function reportToSentry($e)
	{
		return
			parent::shouldReport($e) &&
			! App::environment(['dev', 'testing']);
	}
}
