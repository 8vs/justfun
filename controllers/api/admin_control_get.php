<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 3) {
	fail('Access denied.');
}

if (isset($_GET))
{
	/* Функция получения списка таблиц */
	function getTables()
	{
		$result = array();

		$query = mysql_query('SHOW TABLES');
		while ($row = mysql_fetch_assoc($query)) {
			$item = array_values($row);
			$result[] = $item[0];
		}

		return $result;
	}

	/* Функция получения колонок сущности по её имени */
	function getColumnFromTable($table) {
		$result = array();

		$query = mysql_query("SHOW COLUMNS FROM $table");

		while ($row = mysql_fetch_assoc($query))
		{
			/* Делаем удобнее формат полей */
			$row['field'] = $row['Field'];
			$row['extra'] = (bool) strlen($row['Extra']);

			/* Очищаем ненужные */
			unset(
				$row['Type'],
				$row['Null'],
				$row['Key'],
				$row['Default'],
				$row['Field'],
				$row['Extra']
			);

			$result[] = $row;
		}

		return $result;
	}

	function getValuesFromTable($table)
	{
		$result = array();

		$query = mysql_query("SELECT * FROM $table");
		while ($row = mysql_fetch_assoc($query)) {
			$result[] = $row;
		}

		return $result;
	}

	$show = $_GET['show'];

	/* Валидация GET */
	$validate = array('tables', 'column', 'values');

	if (
		empty($show) ||
		! in_array($show, $validate)
	) {
		fail('Не переданы обязательные параметры');
	}

	if ($show === $validate[0]) {
		$data = getTables();

		success($data);
	}
	else if ($show === $validate[1] && ! empty($_GET['tableName']))
	{
		$data = getColumnFromTable($_GET['tableName']);

		success($data);
	}
	else if ($show === $validate[2] && ! empty($_GET['tableName']))
	{
		$data = getValuesFromTable($_GET['tableName']);

		success($data);
	}

	fail('Указаны некорректные параметры.');
}
