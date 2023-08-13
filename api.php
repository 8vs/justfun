<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, UPDATE, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require __DIR__ . './controllers/api/api_helpers.php';
require __DIR__ . './token.php';

// 05d3aec035bc6622c1b677f802ae9fd2.eyJ4eXUiOnRydWV9
if (isset($_GET['q'])) {
	success(
		array(
			'token' => createToken(
				array(
					'xyu'=>true,
					'time'=>TOKEN_LIMIT
				)
			)
		)
	);
}

$token = $_SERVER['HTTP_AUTHORIZATION'];

if (empty($token)) {
	fail('Не авторизован', 401);
}


try {
	success(
		array('data' => parseToken($token))
	);
} catch (\Exception $e) {
	fail($e->getMessage(), 403);
}