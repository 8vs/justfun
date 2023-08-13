<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации */
if (! isset($_SESSION['user_id'])) {
	fail('Access denied.');
}

/* Валидация формы */
if (
	! isset($_POST['serv']) ||
	! isset($_POST['anim']) ||
	! isset($_POST['date']) ||
	! isset($_POST['place']) ||
	! isset($_POST['captcha']) ||
	(
		empty($_POST['serv']) ||
		empty($_POST['anim']) ||
		empty($_POST['date']) ||
		empty($_POST['place']) ||
		empty($_POST['captcha'])
	)
) {
	fail('Вы не заполнили обязательные поля.');
}

$checkCaptcha = crypt($_POST['captcha'], '$1$itchief$7');

if ($checkCaptcha !== $_SESSION['captcha']) {
    fail('Капча введена неверно.');
}

$xDate = strtotime($_POST['date']);

/* Валидация даты */
if ($xDate < time()) {
	fail('Дата не может быть прошедшей.');
}

/* ---------------------------------- */
/* Начинается блок, где самое вкусное */
/* ---------------------------------- */

/* Определяем количество аниматоров по балансу (мы фрики :)) */
$whoAnimator = (int) $_POST['anim'];
$checkAnimator = mysql_query("SELECT * FROM price WHERE amount = '$whoAnimator'");
$listAnimator = mysql_fetch_array($checkAnimator);

if (! isset($listAnimator['priceid'])) {
	fail('Не удалось определить количество аниматоров.');
}

$user_id = $_SESSION['user_id'];

/* Список сервисов (эквивалентно количеству итераций для деталей заказа) */
$services = array_keys($_POST['serv']);
/* Количество аниматоров (эквивалентно количеству итераций для сущности `workers`) */
$animatorCount = (int) $listAnimator['priceid'];

/* Дата и время, место с формы */
$dateOrder = date('Y-m-d', $xDate);
$timeOrder = date('H:i', $xDate);
$placeOrder = $_POST['place'];

$addOrder = mysql_query("INSERT INTO orders VALUES (null, '$user_id', '$dateOrder','$placeOrder','$timeOrder')");

if ($addOrder)
{
	/* ID нашего заказа */
	$orderId = mysql_insert_id();

	/* Формирование деталей */
	foreach ($services as $service) {
		$addOrderItems = mysql_query("INSERT INTO order_items VALUES (null, '$orderId', '$service')");
		if (! $addOrderItems) {
			fail('Ошибка при формировании деталей заказа (order_items).');
			/* В перспективе тут удалить полностью заказ, который мы сформировали в $addOrder */
		}
	}

	$null_ed = 0;
	/* Формирование в сущности `workers` */
	for ($i = 0; $i < $animatorCount; $i++) {
		$addToWorkers = mysql_query("INSERT INTO workers (orderid) VALUES ('$orderId')");
		if (! $addToWorkers) {
			fail('Ошибка при формировании деталей заказа (workers).');
		}
	}
	
	/* Текст для сообщения */
	$text = "Ваш заказ номер ".$orderId." успешно сформирован. Спасибо за то, что Вы выбрали нас. \n \n Дата: ".$dateOrder.". Время: ".$timeOrder.". Место: ".$placeOrder.". На вашем празднике будет ".$animatorCount." аниматоров (стоимость: ".$whoAnimator."). Услуги: \n";
	
	$text1 = "Сформирован заказ номер ".$orderId.". \n \n Дата: ".$dateOrder.". Время: ".$timeOrder.". Место: ".$placeOrder.". Кол-во аниматоров: ".$animatorCount." (стоимость: ".$whoAnimator."). Услуги: \n";

	$sum = $whoAnimator;

	/* Формирование деталей */
	$res = mysql_query("select orders.orderid, services.title, services.amount from order_items, services, orders where orders.orderid=order_items.orderid and order_items.serviceid=services.serviceid and orders.orderid='$orderId'");
		
	while ($row = mysql_fetch_row($res))
	{
		$text .= $row[1]." (цена: ".$row[2].") \n";
		$text1 .= $row[1]." (цена: ".$row[2].") \n";
		$sum += $row[2];
	}
	
	$res1 = mysql_query("select * from customers where customerid='$user_id'");
	$row1 = mysql_fetch_row($res1);
	
	$text .= " \n Итоговая стоимость заказа равна ".$sum.".";
	$text1 .= " \n Итоговая стоимость заказа равна ".$sum.". \n ИД заказчика: ".$user_id.". Почта для связи: ".$row1[4];
	
	mail('dariiiasta@gmail.com', 'Заказы', $text1);
	if (mail($row1[4], 'Заказ праздника в JustFun', $text)){
		success('Заказ успешно сформирован');}
}
else {
	fail('Не удалось добавить заказ.');
}

