<?php

	namespace App\Exceptions;

	use Symfony\Component\HttpKernel\Exception\HttpException;

	class TraviloException extends HttpException {
		public function __construct($message, $code = NULL, \Exception $previous = NULL) {

			$statusCode = 400;

			if ( ! isset($code)) {
				$code = 9999;
			} elseif (isset($code)) {
				$statusCode = $code;
			}

			parent::__construct($statusCode, $message, $previous, [], $code);
		}
	}
