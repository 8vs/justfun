<?php

include __DIR__ . ('\\..\\config\\db.php');
include __DIR__ . ('\\..\\controllers\api\api_helpers.php');


if (isset($_POST['comment_id']))
{

    $comment_id = $_POST['comment_id'];
	
	$list = mysql_query("SELECT likes.customerid, customers.name FROM likes, customers WHERE likes.comment_id = '$comment_id' AND likes.customerid = customers.customerid");
	
	if (! $list) {
		fail('Не удалось получить список пользователей.', 400);
	}
	
	// $exist = mysql_num_rows($list) > 0);
	
	$result = array();
	while ($row = mysql_fetch_assoc($list)) {
		$result[] = $row['name'];
	}

	success($result);
}