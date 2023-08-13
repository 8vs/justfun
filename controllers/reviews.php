<?php

include __DIR__ . ('\\..\\config\\db.php');

if (isset($_POST['submit']))
{
	$text = $_POST['text'];

	if (empty($text)) {
		$result = 'Заполните поле отзыва';
	} else {
		$date = date('Y.m.d');
		$uid = $_SESSION['user_id'];

		$added = mysql_query("INSERT INTO reviews VALUES (null,'$text','$date','$uid')");

		if ($added) {
			$result = 'Отзыв был успешно добавлен';
		} else {
			$result = 'Не удалось добавить отзыв';
		}
	}
}