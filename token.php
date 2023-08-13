<?php

define('APP_SECRET_KEY', '060807');
define('TOKEN_LIMIT', time() + 60 * 15);

function createToken($data)
{
	$payload = base64_encode(json_encode($data));
	$hash = md5(APP_SECRET_KEY . $payload);

	return $hash. '.' .$payload;
}

/**
 * @throws Exception
 */
function parseToken($token)
{
	$exp = explode('.', $token);

	if (count($exp) !== 2) {
		throw new \Exception('Невалидный токен.');
	}

	$hash = md5(APP_SECRET_KEY . $exp[1]);

	if ($hash !== $exp[0]) {
		throw new \Exception('Неоригинальная подпись токена.');
	}

	$parsePayload = json_decode(base64_decode($exp[1]), true);

	if ($parsePayload['time'] < time()) {
		throw new \Exception('Вышло время жизни токена.');
	}

	return $parsePayload;
}