<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';
require '../utils/send_rss_utils.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id']) && $_SESSION['role'] !== 3) {
	fail('Access denied.');
}

$message = $_POST['message'];
$rss_id = $_POST['id_rss'];

function getUsersByIdRSS($id) {
	$data = array();
	$rss = mysql_query("
SELECT 
       bb.email 
FROM rss_users aa
    JOIN customers bb
        ON aa.customerid = bb.customerid
WHERE aa.id_rss = '$id' ");

	while ($row = mysql_fetch_assoc($rss)) $data[] = $row['email'];

	return $data;
}


if (isset($_POST) && isset($message) && isset($rss_id))
{
	$desk = mysql_query("INSERT INTO rss_messages VALUES('$rss_id', '$message')");

	if ($desk)
	{
		$data = getUsersByIdRSS($rss_id);
		sending($message, $data);
		
		success();
	} else {
		fail('Не удалось добавить сообщение в базу.');
	}
}