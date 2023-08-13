<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 2) {
	fail('Access denied.');
}

$user = $_SESSION['user_id'];

if (isset($_GET)) {

	$input = $_GET['orders'];

	/* Валидация GET */
	$validate = array('my', 'other');

	if (
		empty($input) ||
		! in_array($input, $validate)
	) {
		fail('Не переданы обязательные поля.');
	}

	function getWorkerById($uid) {
		$result = array();

		$req = mysql_query("SELECT * FROM workers, orders, customers WHERE workers.employid = '$uid' AND orders.orderid = workers.orderid AND orders.customerid = customers.customerid");
		while ($row = mysql_fetch_assoc($req))
		{
			/* Удаление лишних (секретных) полей */
			unset(
				$row['password'],
				$row['login'],
				$row['email'],
				$row['customerid'],
				$row['workerid'],
				$row['employid']
			);

			$result[$row['orderid']] = $row;
		}

		return $result;
	}

	/* Заказы текущего пользователя */
	$myOrders = getWorkerById($user);

	if ($input === $validate[0]) {
		success(array_values($myOrders));
	} else {
		/* Свободные заказы (отфильтрованные в цикле ниже) */
		$myOrderListIds = array_keys($myOrders);
		$otherOrders = getWorkerById(0);

		foreach ($otherOrders as $key => $value) {
			if (in_array($key, $myOrderListIds)) {
				unset($otherOrders[$key]);
			}
		}

		success(array_values($otherOrders));
	}
}