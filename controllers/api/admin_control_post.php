<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 3) {
	fail('Access denied.');
}

if (isset($_POST))
{
	$operation = $_POST['operation'];
	$table = $_POST['table'];
	$demon = $_POST['demon'];

	/* Валидация POST */
	$validate = array('create', 'edit', 'remove');

	if (
		empty($demon) ||
		empty($table) ||
		empty($operation) ||
		! in_array($operation, $validate)
	) {
		fail('Не переданы обязательные параметры.');
	}

	/* Очистка лишних параметров */
	unset(
		$_POST['demon'],
		$_POST['table'],
		$_POST['operation']
	);

	/* Парсим параметр автоинкремента с его значением */
	list($AI_key, $AI_value) = explode(';', $demon);

	switch ($operation) {
		case 'edit':

			/* Магия */
			$set = array();
			foreach ($_POST as $key => $value) $set[] = "$key = '$value'";

			$query = mysql_query("UPDATE $table SET ".join(", ", $set)." WHERE $AI_key = $AI_value");
			if ($query) success(array());
			else fail('Не удалось обновить значения.');

			break;

		case 'remove':
			$query = mysql_query("DELETE FROM $table WHERE $AI_key = $AI_value");
			if ($query) success(array());
			else fail('Не удалось удалить.');

			break;

		case 'create':
			/* F U C K magic */
			$_POST[$AI_key] = 'null';

			$columns = array();
			$values = array();
			foreach ($_POST as $key => $value)
			{
				$columns[] = "$key";
				$values[] = "'$value'";
			}

			$columns = join(', ', $columns);
			$values  = join(', ', $values);

			$sql = "INSERT INTO $table ($columns) VALUES ($values)";

			$query = mysql_query($sql);
			if ($query) success('Успешно запись добавлена.');
			else fail($sql);

			break;

		default:
			fail('Неизвестная ошибка.');
			break;
	}
}