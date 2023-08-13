<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 2) {
	fail('Access denied.');
}

$user = $_SESSION['user_id'];

if (isset($_POST))
{
	$type = $_POST['type'];
	$orderId = $_POST['orderid'];

	/* Валидация POST */
	$validate = array('take', 'dontTake');

	if (
		empty($orderId) ||
		! isset($type) ||
		! in_array($type, $validate)
	) {
		fail('Указаны неверные параметры.');
	}

	/* В зависимости от типа операции выполянем нужную: отказ, либо взятие */
	$condition = $type === $validate[0] ? $user : 0;

	if ($condition) {
		$query = mysql_query("UPDATE workers SET employid = '$user' WHERE employid = 0 AND orderid = '$orderId' LIMIT 1");
	} else {
		$query = mysql_query("UPDATE workers SET employid = 0 WHERE employid = '$user' AND orderid = '$orderId' LIMIT 1");
	}

	if ($query) {
		/* Отправляем пустой ответ со статусом TRUE */
		success(array());
	} else {
		fail('Не удалось обновить статус заказа.');
	}
}