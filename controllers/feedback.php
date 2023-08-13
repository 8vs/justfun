<?php

include __DIR__ . ('\\..\\config\\db.php');
include __DIR__ . ('\\..\\controllers\\sendMail.php');

if (isset($_POST['submit'])) {
	$question = $_POST['question'];

	if (empty($question)) {
		$result = 'Заполните поле вопроса';
	} else {
		$date = date('Y.m.d');
		$uid = $_SESSION['user_id'];
		$answer = 'администратор в скором времени ответит на ваш вопрос';
		$from = 'From ID:'.$uid;
		
		$added = mysql_query("INSERT INTO feedbacks VALUES (null,'$uid','$question','$answer','$date')");

		$text = $question." \n Вопрос от пользователя с ИД: ".$uid;
		
		$res1 = mysql_query("select * from customers where customerid='$uid'");
		$row1 = mysql_fetch_row($res1);
	
		$text .= " \n  Почта для связи: ".$row1[4];

		if ($added) {
			if (mail('dariiiasta@gmail.com', 'Вопросы от пользователей', $text, $from)){
				$result = 'Вопрос был успешно отправлен';
			}
		} else {
			$result = 'Не удалось отправить вопрос';
		}
	}
}