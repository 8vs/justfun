<?php

include __DIR__ . ('\\..\\config\\db.php');

global $result;

if (isset($_POST['submit']))
{
	$user      = $_SESSION['user_id'];
	$name      = $_POST['name'];
	$login     = $_POST['login'];
	$email     = $_POST['email'];
	$phone     = $_POST['phone'];
	$old_password  = $_POST['old_password'];
	$new_password  = $_POST['new_password'];
	$newnew_password  = $_POST['newnew_password'];
	$captcha  = $_POST['captcha'];

    $checkCaptcha = crypt($captcha, '$1$itchief$7');
    if (! isset($captcha) || $checkCaptcha !== $_SESSION['captcha']) {
        $result = 'Капча введена неверно.';
    } else {
		if ($name)
		{
			$addUser = mysql_query("UPDATE customers SET name='$name' WHERE customerid='$user'");

			if ($addUser) {
				$result = 'Успешно изменено';
			} else {
				$result = 'Не удалось изменить данные. Ошибка: '. mysql_error();
			}
		}
		
		if ($email)
		{
			$addUser = mysql_query("UPDATE customers SET email='$email' WHERE customerid='$user'");

			if ($addUser) {
				$result = 'Успешно изменено';
			} else {
				$result = 'Не удалось изменить данные. Ошибка: '. mysql_error();
			}
		}
		
		if ($phone)
		{
			$addUser = mysql_query("UPDATE customers SET phone='$phone' WHERE customerid='$user'");

			if ($addUser) {
				$result = 'Успешно изменено';
			} else {
				$result = 'Не удалось изменить данные. Ошибка: '. mysql_error();
			}
		}
		
		if ($login)
		{
			$addUser = mysql_query("UPDATE customers SET login='$login' WHERE customerid='$user'");

			if ($addUser) {
				$result = 'Успешно изменено';
			} else {
				$result = 'Не удалось изменить данные. Ошибка: '. mysql_error();
			}
		}
		
		if ($old_password)
		{
			$check = mysql_query("SELECT * FROM customers WHERE customerid='$user'");
			$row = mysql_fetch_array($check);
			
			if (sha1($old_password) === $row['password']) {
				if (!$new_password || !$newnew_password) {
					$result = 'Заполните все поля.';
				} else {
					if ($new_password === $newnew_password) {
						$addUser = mysql_query("UPDATE customers SET password=sha1('$new_password') WHERE customerid='$user'");

						if ($addUser) {
							$result = 'Успешно изменено';
						} else {
							$result = 'Не удалось изменить данные. Ошибка: '. mysql_error();
						}
					} else {
						$result = 'Пароли не совпадают.';
					}
				}
			} else {
				$result = 'Старый пароль введён неверно.';
			}
		}
	}
}

if (isset($_POST['delete']))
{
	$user = $_SESSION['user_id'];
	$delUser = mysql_query("DELETE FROM customers WHERE customerid='$user'");

	if ($delUser) {
		$result = 'Ваша учётная запись будет удалена.';
		
		session_start();
		$_SESSION = array();
		setcookie('PHPSESSID', '', time() - 3600, '/');
		session_destroy();

		header('Location: /signin.php');
	} else {
		$result = 'Не удалось выполнить удаление. Ошибка: '. mysql_error();
	}
}