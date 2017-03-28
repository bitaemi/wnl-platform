<?php

namespace App\Exceptions;

use App;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
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

		if (!$production) {
			return parent::render($request, $exception);
		}

		if ($exception instanceof HttpResponseException) {
			return $exception->getResponse();
		}

		if ($exception instanceof AuthenticationException) {
			return $this->unauthenticated($request, $exception);
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

		if (!is_null($request->route()) && $request->route()->getPrefix() === '/payment') {
			Log::critical('Exception on payment path: ' . $exception->getMessage() . ' in ' . $exception->getFile());
		}
		
		return response()->view('errors.500', [], 500);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Illuminate\Auth\AuthenticationException $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('login');
	}
}
