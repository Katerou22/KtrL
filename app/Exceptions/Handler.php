<?php

	namespace App\Exceptions;

	use Exception;
	use Illuminate\Auth\AuthenticationException;
	use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
	use Illuminate\Validation\ValidationException;
	use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
	use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use Symfony\Component\Routing\Exception\MethodNotAllowedException;

	class Handler extends ExceptionHandler {
		/**
		 * A list of the exception types that are not reported.
		 *
		 * @var array
		 */
		protected $dontReport = [
			//
		];

		/**
		 * A list of the inputs that are never flashed for validation exceptions.
		 *
		 * @var array
		 */
		protected $dontFlash = [
			'password',
			'password_confirmation',
		];

		/**
		 * Report or log an exception.
		 *
		 * @param  \Exception $exception
		 *
		 * @return void
		 */
		public function report(Exception $exception) {
			parent::report($exception);
		}

		/**
		 * Render an exception into an HTTP response.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Exception               $exception
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function render($request, Exception $exception) {
			if ($request->is('api/*') || $request->is('api/')) {

				//				if (config('app.debug')) {
				// Add the exception class name, message and stack trace to response
				//					$response[ 'exception' ] = get_class($exception); // Reflection might be better here
				$message = $exception->getMessage();
				$code = $exception->getCode();


				//					$response[ 'trace' ] = $exception->getTrace();
				//				}
				$status = 400;

				switch ($exception) {
					case $exception instanceof NotFoundHttpException:
						return api(NULL, 'Not Found', 404, 404);
						break;
					case $exception instanceof BadRequestHttpException:
						return api(NULL, 'Bad Request', 400, 400);
						break;


					case $exception instanceof MethodNotAllowedException:
						return api(NULL, 'Method Not Allowed', 1200, 405);
						break;
					case $exception instanceof MethodNotAllowedHttpException:
						return api(NULL, 'Method Not Allowed    ', 1200, 405);
						break;
					case $exception instanceof AuthenticationException:
						return api(NULL, 'Not Logged in', 1200, 403);
						break;
					case $exception instanceof \PDOException:
						\Log::info('Request: ' . \Request::url());
						break;
					case $exception instanceof ValidationException:

						$message = $exception->validator->getMessageBag()->toArray();
						foreach ($message as $key => $value) {
							$data[] = implode($value) . ' \n ';
						}


						return api(NULL, implode($data), 1005, $status);
						break;


					//					case $exception instanceof ValidationException:
					//						return api(NULL, 'مشکل در درخواست ها', 1005, 400);
					//						break;
					//					case $exception instanceof QueryException:
					//						return api(NULL, 'مشکل در دیتابیس', 1005, 400);
					//						break;


					default:
				}
				// If this exception is an instance of HttpException
				if ($this->isHttpException($exception)) {
					// Grab the HTTP status code from the Exception
					$status = $exception->getStatusCode();
				}


				// Return a JSON response with the response array and status code
				return api(NULL, $message, $code, $status);

			}


			return parent::render($request, $exception);
		}
	}
