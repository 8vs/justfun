<?php

header('Content-Type: text/html; charset=utf-8');

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 3) {
	fail('Access denied.');
}

function _sub($action, $id) {
	$uid = $_SESSION['user_id'];
	switch ($action) {
		case 'add':
			$add = mysql_query("INSERT INTO rss_users VALUES ('$id', '$uid')");
			if ($add) success();
			else fail('Не удалось оформить подписку.');
			break;

		case 'delete':
			$delete = mysql_query("DELETE FROM `rss_users` WHERE id_rss = '$id' AND customerid = '$uid'");
			if ($delete) success();
			else fail('Не удалось отменить подписку.');
			break;

		default:
			fail('Call incorrect method.');
			break;
	}
}

if (isset($_POST) && isset($_POST['method']) && isset($_POST['method'])) {
	_sub($_POST['method'], $_POST['id']);
} else {
	fail('Не переданы обязательные параметры.');
}