<?php

include __DIR__ . ('\\..\\config\\db.php');

global $result;

if (isset($_POST['submit']))
{
	$name      = $_POST['name'];
	$login     = $_POST['login'];
	$email     = $_POST['email'];
	$phone     = $_POST['phone'];
	$password  = $_POST['password'];
	$city      = $_POST['city'];

	$checkExistUser = mysql_query("SELECT * FROM customers WHERE login='$login'");

if (!$name || !$email || !$phone || !$login || !$password || !$city)
{
$result = 'Пожалуйста, заполните все необъодимые поля. ';
} else{

	if (mysql_num_rows($checkExistUser) > 0) {
		$result = 'Такой пользователь уже существует';
	} else {
		$addUser = mysql_query("INSERT INTO customers values(null, '$name', '$login', sha1('$password'), '$email', '$phone', '$city')");

		if ($addUser) {
			$result = 'Успешная регистрация';
		} else {
			$result = 'Не удалось добавить данные. Ошибка: '. mysql_error();
		}}
	}
}