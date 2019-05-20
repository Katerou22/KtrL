<?php


	use App\app\Http\Utilites\Enum;
	use App\Category;
	use App\Exceptions\SearchableException;
	use App\Exceptions\TraviloException;
	use App\Feature;
	use App\Jobs\AddingBalanceToRedis;
	use App\Jobs\SendAndroidNotification;
	use App\Jobs\SendIosNotification;
	use App\Jobs\SendNotification;
	use App\Jobs\SendSms;
	use App\Order;
	use App\Package;
	use App\Setting;
	use App\Sku;
	use App\TelegramUser;
	use Davibennun\LaravelPushNotification\Facades\PushNotification;
	use GuzzleHttp\Client;
	use Illuminate\Pagination\LengthAwarePaginator;

	function flash($title = NULL, $message = NULL) {
		$flash = app(\App\Http\Utilites\Flash::class);

		if (func_num_args() == 0) {
			return $flash;
		}


		return $flash->info($title, $message);
	}

	function gatewayTransactor(
		$amount, $product, $user, $status, $port, $order, $type = NULL, $type_id = NULL, $ref_id = NULL, $tracking_code = NULL,
		$card_number = NULL
	) {
		$result = DB::transaction(function () use (
			$user, $amount, $product, $ref_id, $status, $tracking_code, $card_number, $port,
			$order, $type, $type_id
		) {

			if (is_null($user)) {
				throw new \Illuminate\Auth\AuthenticationException();
			}
			if ( ! is_null($product)) {
				$type = 'product';
				$type_id = $product->id;

			} elseif ( ! is_null($order)) {
				$type_id = $order->id;
				$type = 'order';

				if ($order instanceof Order) {
					$type = 'order';
				}
				if ($order instanceof \App\Auto) {
					$type = 'auto';

				}
			} elseif ( ! is_null($type)) {
				$type_id = $type_id;
				$type = $type;

			} else {
				return error('Not Authorised');
			}


			$transaction = $user->gatewayTransactions()->create([
				                                                    'type'          => $type,
				                                                    'type_id'       => $type_id,
				                                                    'amount'        => $amount,
				                                                    'ref_id'        => $ref_id,
				                                                    'tracking_code' => $tracking_code,
				                                                    'card_number'   => $card_number,
				                                                    'ip'            => Request::getClientIp(),
				                                                    'status'        => $status,
				                                                    'port'          => $port,
			                                                    ]);


			return $transaction;

		});

		return $result;
	}


	function transactor($user = NULL, $type = NULL, $amount = NULL, $description = NULL) {
		if ($user instanceof \App\User) {

			if ((int) $amount === 1) {

				$last_user_transaction = balance($user);

				if ($type === 'l_coin') {
					$user->update(['l_coin' => $last_user_transaction->l_coin + $amount]);
				} else if ($type === 'f_coin') {
					$user->update(['f_coin' => $last_user_transaction->f_coin + $amount]);
				}

				return $user;

			}

		}


		$amount = (int) $amount;
		$user_transaction = $user->transactions();
		if ($amount < 0) {
			if ($type === 'l_coin') {
				$balance = balance($user);

				if ($balance->l_coin < (- $amount)) {
					return error('PAY_INSUFFICIENT');
				}
			}
			if ($type === 'f_coin') {
				$balance = balance($user);

				if ($balance->f_coin < (- $amount)) {
					return error('PAY_INSUFFICIENT');
				}
			}

		}


		if ($type === 'l_coin') {

			$last_user_transaction = balance($user);

			if ($last_user_transaction === NULL) {
				$f_coin = 0;
				$l_coin = 0;
			} else {
				$f_coin = $last_user_transaction->f_coin;
				$l_coin = $last_user_transaction->l_coin;
			}

			$transaction = $user_transaction->create([
				                                         'amount'      => convert($amount),
				                                         'type'        => 'l_coin',
				                                         'f_coin'      => $f_coin,
				                                         'l_coin'      => convert($l_coin) + convert($amount),
				                                         'description' => $description,
				                                         'created_at'  => \Carbon\Carbon::now(),
			                                         ]);


		} elseif ($type === 'f_coin') {
			$last_user_transaction = balance($user);

			if ($last_user_transaction === NULL) {
				$f_coin = 0;
				$l_coin = 0;
			} else {
				$f_coin = $last_user_transaction->f_coin;
				$l_coin = $last_user_transaction->l_coin;
			}
			$user_transaction = $user->transactions();
			$transaction = $user_transaction->create([
				                                         'amount'      => convert($amount),
				                                         'type'        => 'f_coin',
				                                         'l_coin'      => $l_coin,
				                                         'f_coin'      => $f_coin + convert($amount),
				                                         'description' => $description,
				                                         'created_at'  => \Carbon\Carbon::now(),

			                                         ]);


		} else {
			$transaction = NULL;
		}


		$user->update([
			              'l_coin' => $transaction->l_coin,
			              'f_coin' => $transaction->f_coin,
		              ]);

		return $transaction;
	}


	function api($data = NULL, $message = 'success', $code = 1000, $http_code = 200) {
		$hasPaginate = FALSE;
		if ($message == 'success') {
			$status = 'success';
		} else {
			$status = 'fail';
		}


		$response = [
			'status' => $status,
			'meta'   => [
				'code'    => $code,
				'message' => $message,

			],
			'data'   => $data,

		];

		if ($data !== NULL) {
			if (array_key_exists('resource', $data) && $data->resource instanceof LengthAwarePaginator) {
				$response[ 'meta' ][ 'paginate' ] = [
					'total'        => $data->total(),
					'count'        => $data->count(),
					'per_page'     => $data->perPage(),
					'current_page' => $data->currentPage(),
					'total_pages'  => $data->lastPage(),
					'is_last_page' => $data->lastPage() === $data->currentPage(),
				];
			}

			if (array_key_exists('additional', $data)) {
				foreach ($data->additional as $key => $value) {
					$response[ 'meta' ][ $key ] = $value;

				}
			}
		}


		return response($response, $http_code);


	}

	function error($message, $code = NULL) {

		throw new TraviloException($message, $code, NULL);
	}

	function smsVerify($user, $token) {
		$message = "
      فلوریست
      
      کد فعالسازی:  $token
      ";
		dispatch((new SendSms($user, $message))->onQueue('sms'));
	}

	function sms($user, $message) {

		dispatch((new SendSms($user, $message))->onQueue('sms'));
	}

	function iosQueue($token, $message, $method, $market = 'appstore') {

		if ( ! is_array($message)) {
			$message = [
				'type'  => 'order_finished',
				'alert' => $message,
			];
		}
		if (mb_strlen(serialize($message)) >= 2048) {
			$setting = Setting::where('key', 'notification')->first();
			if (count($setting) > 0) {
				$setting->update([
					                 'value' => json_encode($message),
				                 ]);
			} else {
				Setting::create([
					                'key'   => 'notification',
					                'value' => json_encode($message),
				                ]);
			}
			$message = [
				'link'  => url('/api/v5/get-notif/'),
				'alert' => $message[ 'alert' ],
				'type'  => $message[ 'type' ],
			];
		}

		return dispatch((new SendIosNotification($token, $message, $method, $market))->onQueue('apple'));
	}

	function androidQueue($token, $data, $device = NULL) {
		if ( ! is_array($data)) {
			$data = [
				'type'  => 'order_finished',
				'alert' => $data,
			];
		}
		dispatch((new SendAndroidNotification($token, $data, $device))->onQueue('android'));
	}

	function ios($token, $message, $method = 'cafeig', $market = 'appstore') {
		switch ($method) {
			case('cafeig'):
				if ($market === 'appstore') {
					$method = 'ios-cafeig-appstore';

				} else {
					$method = 'ios-cafeig-sibapp';
				}


				break;
			case('happyinsta'):
				$method = 'ios-happyinsta-appstore';
				break;
			default:
				if ($market === 'appstore') {
					$method = 'ios-cafeig-appstore';

				} else {
					$method = 'ios-cafeig-sibapp';
				}
				break;

		}
		if ( ! is_array($message)) {
			$message = [
				'type'  => 'order_finished',
				'alert' => $message,
			];
		}
		if (mb_strlen(serialize($message)) >= 2048) {
			$setting = Setting::where('key', 'notification')->first();
			if (count($setting) > 0) {
				$setting->update([
					                 'value' => json_encode($message),
				                 ]);
			} else {
				Setting::create([
					                'key'   => 'notification',
					                'value' => json_encode($message),
				                ]);
			}
			$message = [
				'link'  => url('/api/v5/get-notif/'),
				'alert' => $message[ 'alert' ],
				'type'  => $message[ 'type' ],
			];
		}

		$msg = PushNotification::Message($message[ 'alert' ], [
			'custom' => ['data' => $message],
		]);

		$push = PushNotification::app($method);
		$push->to(strtolower($token))->send($msg);
	}

	function android($token, $data, $device = NULL) {
		if ( ! is_array($data)) {
			$data = [
				'type'  => 'order_finished',
				'alert' => $data,
			];
		}
		if ($device !== NULL && (int) $device->version > 900) {
			fcm()
				->to([$token])// $recipients must an array
				->data($data)
				->send();
		} else {

			$message = PushNotification::Message('Hello', $data);

			$push = PushNotification::app('android');
			$push->to($token)->send($message);
		}

	}

	function notif($user, $title = NULL, $data = NULL) {
		if ($user instanceof \App\User) {


			$tokens = collect([]);
			$user_devices = $user->devices;
			if ($user_devices !== NULL) {
				foreach ($user_devices as $device) {

					if ($device->pivot->notification_token !== NULL) {

						$tokens->push([
							              'token'  => $device->pivot->notification_token,
							              'device' => $device,
						              ]);

					}

				}
				if (count($tokens->unique('token')->values()->all()) > 0) {


					foreach ($tokens->unique('token')->values()->all() as $token) {
						$device = $token[ 'device' ];
						$token = $token[ 'token' ];


						if (NULL === $token) {
							continue;
						}


						if ($device->app_name === 'happyinsta') {
							\App::setLocale('en');
						} else {
							\App::setLocale('fa');
						}


						if (is_array($title)) {
							$msg = $title;
						} else {
							if ($data !== NULL) {
								$type = $data[ 'type' ];
								$attributes = [];

								if ($device->app_name === 'happyinsta') {
									//en
									foreach ($data[ 'data' ] as $key => $value) {
										if ($value === 'فالو') {
											$value = 'Follower';
										}
										if ($value === 'لایک') {
											$value = 'Like';
										}
										if ($value === 'کامنت') {
											$value = 'Comment';
										}
										$value = convert($value);
										$attributes[ $key ] = $value;

									}


								} else {
									//fa
									foreach ($data[ 'data' ] as $key => $value) {
										if ($value === 'Followers') {
											$value = 'فالوور';
										}
										if ($value === 'Likes') {
											$value = 'لایک';
										}
										if ($value === 'Comments') {
											$value = 'کامنت';
										}
										$value = unConvert($value);
										$attributes[ $key ] = $value;


									}
								}

								$title = __($type, $attributes);


							}

							$msg = [
								'type'  => 'order_finished',
								'alert' => $title,
							];
						}
						if (strtolower($device->os) === 'android') {
							androidQueue($token, $msg, $device);


						}

						if (strtolower($device->os) === 'ios') {
							if (strlen($token) !== 64) {
								\Log::info("Device id of failed " . $device->id);

								\Log::info("User with Wrong APN token " . $user->id);

								return;
							}
							iosQueue($token, $msg, $device->app_name, $device->market);
						}

					}
				}

			}
		}


	}

	function redisSet($key, $value) {
		return Redis::set($key, json_encode($value));
	}

	function redisGet($key) {
		return json_decode(Redis::get($key));
	}


	function convert($value) {
		$western = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
		$eastern = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];


		return str_replace($eastern, $western, $value);
	}

	function unConvert($value) {
		$western = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
		$eastern = ['۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '۰'];


		return str_replace($western, $eastern, $value);
	}


	function getRandomString($length = 6) {
		$valid_chars = '123456789MNBVCXZLKJHGFDSAPUYTREWQ';
		$random_string = '';
		$num_valid_chars = strlen($valid_chars);
		for ($i = 0; $i < $length; $i ++) {
			$random_pick = mt_rand(1, $num_valid_chars);
			$random_char = $valid_chars[ $random_pick - 1 ];
			$random_string .= $random_char;
		}

		return $random_string;
	}

	function userAgent($request) {

		try {
			if (is_null($request->header('User-Agents'))) {
				$req = $request->header('User-Agent');
			} else {
				$req = $request->header('User-Agents');
			}


			$header = strstr($req, ' (', FALSE);

			$header = str_replace(' (', '', $header);
			$header = str_replace(')', '', $header);
			$agent = [];
			$header = explode('; ', $header);
			$agent[ 'os' ] = strtolower($header[ 0 ]);
			$agent[ 'app_name' ] = strtolower(strtok($req, ' '));
			$agent[ 'version_code' ] = strtolower($header[ 1 ]);
			$agent[ 'market' ] = strtolower($header[ 2 ]);
			$agent[ 'country' ] = strtolower($header[ 3 ]);
			$agent[ 'device_id' ] = $header[ 4 ];
			$agent[ 'lang' ] = strtolower($header[ 5 ]);

			return $agent;
		} catch (Exception $e) {
			return error('User Agent Wrong!');
		}


		return $agent;
	}


	function enc($data, $iv, $key = 'dde717bc4fd78bbbd98ccc7d8516ba79') {
		return openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
	}

	function dec($data, $iv, $key = 'dde717bc4fd78bbbd98ccc7d8516ba79') {
		return openssl_decrypt($data, 'AES-256-CBC', $key, 0, $iv);
	}


	function liteNumbers() {
		return [
			'Comments'  => 1,
			'Followers' => 20,
			'Likes'     => 10,
		];

	}

	function getLAofDb() {
		$output = shell_exec("sh /home/files/scripts/checkdbload.sh");

		return $output;
	}

	function checkBan($user) {
		if ($user instanceof \App\User) {
			if (\App\Ban::where('user_id', $user->id)->first() === NULL) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}


	}

	function isRestricted($for_id) {

		$for_id = strstr($for_id, '_', FALSE) ?: $for_id;
		$for_id = str_replace('_', '', $for_id);


		if (\App\Restrict::where('instagram_id', $for_id)->first() !== NULL) {
			return TRUE;
		} else {
			return FALSE;
		}


	}

	function elastic($project) {
		return new \App\Http\Utilities\Elastic($project);

	}

	function csvToArray($filename = '', $delimiter = ',') {
		if ( ! file_exists($filename) || ! is_readable($filename)) {
			return FALSE;
		}

		$header = NULL;
		$data = [];
		if (($handle = fopen($filename, 'r')) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
				if ( ! $header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}

		return $data;
	}

	function jsonToArray($filename) {

		$string = file_get_contents($filename);

		//		$data = [];

		return json_decode($string, TRUE);
		//		dd();
		//
		//		foreach (json_decode($string, TRUE) as $value) {
		//			foreach ($value as $k => $v) {
		//				if ($v !== NULL) {
		//					$data[][][ $k ] = $v;
		//
		//				}
		//
		//
		//			}
		//		}
		//		dd($data);

		return $data;

	}

	function ___($project, $name, $change = TRUE) {
		if ($change) {

			$type = strtolower(str_replace(' ', '_', $name));

			return $project->name . '_' . $type;
		} else {
			return str_replace($project->name . '_', '', $name);
		}


	}


	function tab2space($line, $tab = 4, $nbsp = FALSE) {
		while (($t = mb_strpos($line, "\t")) !== FALSE) {
			$preTab = $t ? mb_substr($line, 0, $t) : '';
			$line = $preTab . str_repeat($nbsp ? chr(7) : ' ', $tab - (mb_strlen($preTab) % $tab)) . mb_substr($line, $t + 1);
		}

		return $nbsp ? str_replace($nbsp ? chr(7) : ' ', '&nbsp;', $line) : $line;
	}

	function mongo($project) {
		return new \App\Http\Utilities\Mongo($project);
	}

	function getCity($lat, $long) {
		$key = 'AIzaSyCB46xbCQC7Qp3bfG87hZS7iRr7WxpKavg';
		$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=$key&sensor=true";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		$result = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http_code !== 200) {
			return FALSE;
		}


		$result = json_decode(json_encode($result, TRUE));

		foreach (json_decode($result)->results as $result) {
			foreach ($result->address_components as $address_component) {
				if (in_array('locality', $address_component->types, TRUE)) {
					return strtolower($address_component->short_name);
				}
			}

		}

		return NULL;
	}

	function normalise($text) {
		$reserves = [
			'+',
			'-',
			'=',
			'&&',
			'||',
			'!',
			'(',
			')',
			'{',
			'}',
			'[',
			']',
			'^',
			'"',
			'~',
			'*',
			'?',
			':',
			'/',
			'>',
			'<',
		];

		$replace = [
			'\+',
			'\-',
			'\=',
			'\&&',
			'\||',
			'\!',
			'\(',
			'\)',
			'\{',
			'\}',
			'\[',
			'\]',
			'\^',
			'\"',
			'\~',
			'\*',
			'\?',
			'\:',
			'\/',
			'',
			'',
		];


		$text = str_replace('\\', '\\\\', $text);
		$text = str_replace($reserves, $replace, $text);

		return $text;


	}

	function itemsResource($items) {


		$data = [];
		foreach ($items as $item) {
			unset($item[ '_elastic_id' ], $item[ '_type' ], $item[ 'suggest' ], $item[ '_id' ], $item[ 'highlight' ]);
			$data[] = $item;
		}

		return $data;

	}

	function itemResource($item) {


		unset($item[ '_elastic_id' ], $item[ '_type' ], $item[ 'suggest' ], $item[ '_id' ], $item[ 'highlight' ]);

		return $item;

	}

	function createSuggest($project, $index_name, $data) {
		$suggest = '';
		foreach ($data as $d) {

			if (gettype($d) === 'array') {
				foreach ($d as $a) {
					if (gettype($a) === 'array') {
						foreach ($a as $a_f) {
							$suggest .= $a_f . ' ';

						}
					} else {
						$suggest .= $a . ' ';

					}


				}
			}
			if (gettype($d) === 'string') {
				$suggest .= $d . ' ';

			}


		}
		$suggest = trim($suggest);

		$suggest = elastic($project)->analyze($index_name, $suggest);

		return ['input' => $suggest];
	}

	function placeSearch($lat, $long, $radius = 2500) {

		$key = 'AIzaSyCB46xbCQC7Qp3bfG87hZS7iRr7WxpKavg';
		$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$long&radius=$radius&key=$key&rankedby=distance";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);


		$result = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http_code !== 200) {
			return FALSE;
		}

		return json_decode($result);
	}

	function geoIP($ip) {
		$url = "http://getcitydetails.geobytes.com/GetCityDetails?fqcn=$ip";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);


		$result = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($http_code !== 200) {
			return FALSE;
		}

		return json_decode($result);

	}

	function getPlacePhoto($photo_id, $width, $name) {
		$key = 'AIzaSyCB46xbCQC7Qp3bfG87hZS7iRr7WxpKavg';

		$url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=$width&photoreference=$photo_id&key=$key";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		$result = curl_exec($ch);

		//		\Intervention\Image\Facades\Image::make($result)->save('img/' . $name . '.jpg');
	}

	function upImage($file, $path, $thumbnail = FALSE, $name = NULL) {
		$photo_from_request = $file;
		$photo = \Intervention\Image\Facades\Image::make($photo_from_request);
		$thumb_path = NULL;

		if ($path[ 0 ] === '/') {
			if ($thumbnail) {
				$thumb_path = public_path() . '/thumbnails' . $path;

			}
			$path = public_path() . '/images' . $path;


		} else {
			if ($thumbnail) {
				$thumb_path = public_path() . '/thumbnails/' . $path;

			}
			$path = public_path() . '/images/' . $path;

		}

		if ( ! File::isDirectory($path)) {
			File::makeDirectory($path, 493, TRUE);

		}

		$name = $name ?? time() . '.' . $photo_from_request->getClientOriginalExtension();


		$original = $path . $name;
		$photo->save($original);
		if ($thumbnail) {
			if ( ! File::isDirectory($thumb_path)) {
				File::makeDirectory($thumb_path, 493, TRUE);

			}
			$thumb = $thumb_path . $name;
			$photo->resize(150, 150);
			$photo->save($thumb);
		}

		return $name;


	}


