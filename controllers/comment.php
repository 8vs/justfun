<?php

include __DIR__ . ('\\..\\config\\db.php');
include __DIR__ . ('\\..\\controllers\api\api_helpers.php');

if (isset($_POST['submit']))
{
	$text = $_POST['text'];
	$parent = $_POST['com_parent'];
    $date = date('Y.m.d H:i');

	if (empty($text)) {
		$result = 'Заполните поле сообщения';
	} else {
		$uid = $_SESSION['user_id'];

		$added = mysql_query("INSERT INTO comment VALUES (null,'$uid','$text','$parent', '$date' )");

		if ($added) {
			$result = 'Сообщение было успешно добавлено';
		} else {
			$result = 'Не удалось добавить сообщение';
		}
	}
}

else if ( isset($_POST['like']) && isset($_POST['method']) && isset($_POST['comment_id']) )
{

    if (! isset($_SESSION['user_id'])) {
        fail('Не авторизован.', 400);
    }


    $method = $_POST['method'];
	$comment_id = $_POST['comment_id'];
	$uid = $_SESSION['user_id'];
	
	$check = mysql_query("SELECT * FROM likes WHERE comment_id = '$comment_id' AND customerid = '$uid'");
	$exist_like = (mysql_num_rows($check) > 0);
	
	if ($method === 'add')
	{
		if ($exist_like) 
		{
			fail('Лайк уже стоит', 400);
			
		} else {
			$added = mysql_query("INSERT INTO likes VALUES (null,'$comment_id','$uid')");

			if ($added) {
				success();
			} else {
				fail('Не удалось добавить лайк', 400);
			}
		}
	}
	
	else if ($method === 'un') 
	{
		if ($exist_like) 
		{
			$un = mysql_query("DELETE FROM likes WHERE comment_id='$comment_id' AND customerid='$uid';");
			
			if ($un) {
				success();
			} else {
				fail('Не удалось убрать лайк.', 400);
			}
			
		} else {
			fail('Лайк не стоит.', 400);
		}
	}
}