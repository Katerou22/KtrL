<?php

	namespace App\Exceptions;

	use Symfony\Component\HttpKernel\Exception\HttpException;

	class TraviloException extends HttpException {
		public function __construct($message, $max = NULL, \Exception $previous = NULL) {

			switch ($message) {
				case('DISCOUNT_USED'):
					$message = 'این تخفیف را قبلا استفاده کرده اید.';
					$code = 1010;
					$statusCode = 403;
					break;
				case ('DISCOUNT_EXPIRED'):
					$message = 'این تخفیف منقضی شده است.';
					$code = 1011;
					$statusCode = 423;
					break;
				case ('DISCOUNT_MIN'):
					$message = 'مقدار خرید شما کمتر از حداقل مقدار این تخفیف است.';
					$code = 1012;
					$statusCode = 499;
					break;
				case ('DISCOUNT_FULL'):
					$message = 'ظرفیت استفاده از این تخفیف پر شده است.';
					$code = 1013;
					$statusCode = 499;
					break;
				case ('DISCOUNT_EXCLUSIVE'):
					$message = 'این تخفیف متعلق به شما نیست.';
					$code = 1014;
					$statusCode = 403;
					break;
				case ('DISCOUNT_NOT_FOUND'):
					$message = 'تخفیف پیدا نشد!';
					$code = 1015;
					$statusCode = 404;
					break;
				case ('REQUEST_REQUIRE'):
					$message = 'مشکل در ارسال درخواست ها.';
					$code = 1020;
					$statusCode = 416;
					break;
				case ('CANT_TRANSFER'):
					$message = 'شما شروط لازم برای انتقال سکه را ندارید!';
					$code = 1030;
					$statusCode = 401;
					break;
				case ('MAX_RECEIVE_ACHIEVED'):
					$message = 'با این دریافت شما مرز 5000 سکه در روز را رد میکنید!';
					$code = 1031;
					$statusCode = 401;
					break;
				case ('MAX_SENT_ACHIEVED'):
					$message = 'شما در امروز مرز انتقال سکه را رد کرده اید!';
					$code = 1031;
					$statusCode = 401;
					break;
				case ('MINIMUM_AMOUNT'):
					$message = 'حداقل میزان انتقال 100 سکه است!';
					$code = 1032;
					$statusCode = 401;
					break;
				case ('MAXIMUM_AMOUNT'):
					$message = "حداکثر میزان انتقال  $max سکه است!";
					$code = 1032;
					$statusCode = 401;
					break;
				case ('PAY_PAID'):
					$message = 'این سفارش قبلا پرداخت شده است.';
					$code = 1040;
					$statusCode = 403;
					break;
				case ('PAY_INSUFFICIENT'):
					$message = 'موجودی کافی نیست.';
					$code = 1041;
					$statusCode = 406;
					break;
				case ('STEP_NOT_FOUND'):
					$message = 'وضعیت برای سفارش پیدا نشد.';
					$code = 1042;
					$statusCode = 404;
					break;
				case ('NO_GATEWAY'):
					$message = 'محصول خریداری شده ای ندارید.';
					$code = 1043;
					$statusCode = 400;
					break;
				case ('NO_CART_OPEN'):
					$message = 'سبد خرید باز شده ای ندارید.';
					$code = 1044;
					$statusCode = 400;
					break;
				case ('CART_EMPTY'):
					$message = 'سبد خرید نمیتواند خالی باشد.';
					$code = 1045;
					$statusCode = 400;
					break;
				case ('RECEIPT_NOT_FOUND'):
					$message = 'ٰرسید پیدا نشد!';
					$code = 1046;
					$statusCode = 404;
					break;
				case ('TRANSACTION_NOT_FOUND'):
					$message = 'تراکنش پیدا نشد!';
					$code = 1047;
					$statusCode = 404;
					break;
				case ('USER_NOT_FOUND'):
					$message = 'کاربر یافت نشد.';
					$code = 1050;
					$statusCode = 404;
					break;
				case ('DUPLICATE_USER'):
					$message = 'این اینستاگرام توکن قبلا ثبت شده است!';
					$code = 1051;
					$statusCode = 400;
					break;
				case ('TOKEN_EXPIRED'):
					$message = 'موعد تعیین شده برای استفاده از کد به پایان رسیده است.';
					$code = 1052;
					$statusCode = 401;
					break;
				case ('WEEK_NOT_FOUND'):
					$message = 'پکیج در این روز موجود نمیباشد.';
					$code = 1060;
					$statusCode = 404;
					break;
				case ('HOUR_NOT_FOUND'):
					$message = 'پکیج در این ساعت موجود نمیباشد.';
					$code = 1061;
					$statusCode = 404;
					break;
				case ('TOKEN_MISS'):
					$message = 'کد پیدا نشد.';
					$code = 1070;
					$statusCode = 404;
					break;
				case ('VERIFIED'):
					$message = 'این شماره قبلا تایید شده است.';
					$code = 1071;
					$statusCode = 400;
					break;
				case ('QUANTITY_MAX_REACHED'):
					$message = 'تعداد شاخه وارد شده از تعداد ماکسیموم شاخه بیشتر است.';
					$code = 1080;
					$statusCode = 400;
					break;
				case ('QUANTITY_MIN_REACHED'):
					$message = 'تعداد شاخه وارد شده از تعداد مینیموم شاخه کمتر است.';
					$code = 1080;
					$statusCode = 400;
					break;
				case ('PACKAGE_NOT_FOUND'):
					$message = 'پکیج پیدا نشد';
					$code = 1080;
					$statusCode = 400;
					break;
				case ('PASSWORD_INCORRECT'):
					$message = 'رمز عبور قدیمی اشتباه است.';
					$code = 1090;
					$statusCode = 401;
					break;
				case ('INVALID_QUANTITY'):
					$message = 'مقدار نا معتبر است.';
					$code = 1100;
					$statusCode = 400;
					break;
				case ('OWN_PERFORM'):
					$message = 'شما نمیتوانید سفارش خود را لایک یا فالو کنید!';
					$code = 1110;
					$statusCode = 400;
					break;
				case ('OWN_TRANSFER'):
					$message = 'شما نمیتوانید برای خودتان سکه انتقال دهید';
					$code = 1120;
					$statusCode = 400;
					break;
				case ('GOT_REWARD'):
					$message = 'شما قبلا این جایزه را دریافت کرده اید!';
					$code = 1120;
					$statusCode = 400;
					break;
				case ('INCORRECT_LINK'):
					$message = 'Link is incorrect';
					$code = 1200;
					$statusCode = 400;
					break;
				case ('SERVICE_NO_MATCH_LINK'):
					$message = 'Service does not match with link.';
					$code = 1210;
					$statusCode = 400;
					break;
				case ('EXPIRED_LINK'):
					$message = 'Link is valid but content is expired.';
					$code = 1220;
					$statusCode = 400;
					break;
				case ('RESTRICTED_CONTENT'):
					$message = 'Content is restricted for some countries.';
					$code = 1221;
					$statusCode = 400;
					break;
				case ('ORDER_NOT_FOUND'):
					$message = 'Order not Found.';
					$code = 1230;
					$statusCode = 404;
					break;
				case ('ORDER_IN_PROGRESS'):
					$message = 'This order is still in progress.';
					$code = 1231;
					$statusCode = 400;
					break;
				case ('ORDER_NOT_IN_PROGRESS'):
					$message = 'This order is not in progress.';
					$code = 1232;
					$statusCode = 400;
					break;
				case ('NO_DROP'):
					$message = 'This order has no drop.';
					$code = 1233;
					$statusCode = 400;
					break;

			}

			if ( ! isset($statusCode) || ! isset($code)) {
				$statusCode = 400;
				$code = 9999;
			}
			parent::__construct($statusCode, $message, $previous, [], $code);
		}
	}
