<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id'])) {
	fail('Access denied.');
}

function getList($my = false) {
	$data = array();
	$getList = mysql_query("SELECT * FROM rss");
	while ($row = mysql_fetch_assoc($getList)) {

		if ($my) {
			$data[] = array_merge(
				$row,
				array('sub' => checkSub($row['id_rss']))
			);
		} else {
			$data[] = $row;
		}
	}

	return $data;
}

function checkSub($rss_id)
{
	$uid = $_SESSION['user_id'];
	$check = mysql_query("SELECT * FROM rss_users WHERE id_rss = '$rss_id' AND customerid = '$uid'");
	$result = mysql_fetch_assoc($check);

	return !!$result;
}

if (isset($_GET)) {
	$data = getList(isset($_GET['my']));
	success($data);
}