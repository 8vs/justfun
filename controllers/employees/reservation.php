<?php

include ('\\..\\..\\config\\db.php');

$option = $_POST['option'];
$item = $_POST['item'];

if (isset($_POST) && isset($option) && isset($_POST['item'])) {
	$user = $_SESSION['user_id'];

	switch ($option) {
		case 'add':
			$added = mysql_query("UPDATE workers SET employid = '$user' WHERE orderid = '$item';");
			if ($added) {
				header('Refresh: 0');
			} else {
				echo 'Ошибка доступа';
			}

			break;

		case 'remove':
			$remove = mysql_query("UPDATE workers SET employid = 0 WHERE orderid = '$item';");
			if ($remove) {
				header('Refresh: 0');
			} else {
				echo 'Ошибка доступа';
			}

			break;
	}
}