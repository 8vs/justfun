<?php

function success($data = array(), $code = null) {
	prom(true, $data, $code);
}

function fail($error, $code = null) {
	prom(false, $error, $code);
}

function prom($status, $content, $code) {
	header('Content-Type: application/json');

	if (isset($code)) {
		http_response_code($code);
	}

	echo json_encode(
		array(
			'status' => $status,
			'content' => $content
		)
	);

	exit;
}

function http_response_code($code = 200)
{
	$text = '';

	switch ($code) {
		case 200:
			$text = 'OK';
			break;
		case 201:
			$text = 'Created';
			break;
		case 400:
			$text = 'Bad Request';
			break;
		case 401:
			$text = 'Unauthorized';
			break;
		case 403:
			$text = 'Forbidden';
			break;
		case 404:
			$text = 'Not Found';
			break;
		case 405:
			$text = 'Method Not Allowed';
			break;
		case 500:
			$text = 'Internal Server Error';
			break;
	}

	header("HTTP/1.1 $code $text");
}