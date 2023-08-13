<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Итоги работы</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Ставка на предстоящие заказы</a>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active mb-auto" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
<?php

$user = $_SESSION['user_id'];

$result4 = mysql_query("select workers.orderid from workers, orders where orders.orderid=workers.orderid and workers.employid='$user' and orders.date_ord <= CURRENT_DATE");

while ($row2 = mysql_fetch_row($result4))
{
	$an=0;
	echo ' Работал на заказe: ';
	echo stripslashes($row2[0]);

	$result7 = mysql_query("select workers.employid from workers, orders where orders.orderid=workers.orderid and orders.orderid='$row2[0]'");

	while ($row5 = mysql_fetch_row($result7))
	{
		$an=$an+1;
	}

	$result11 = mysql_query("select amount from price where priceid='$an'");

	$row11 = mysql_fetch_row($result11);

	echo '<br/> Оплата: ';
	echo $row11[0]/$an;

	$sum = $sum+1;
	$zp=$zp+$row11[0]/$an;
}

echo '<br/> ';echo '<br/> ';

echo ' Общее кол-во заказов: ';
echo $sum;

echo '. Заработок: ';
echo $zp;
?>
</div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
<?php
$result4 = mysql_query("select workers.orderid from workers, orders where orders.orderid=workers.orderid and orders.date_ord >= CURRENT_DATE and workers.employid='0' group by workers.orderid");

while ($row2 = mysql_fetch_row($result4))
{
	$an=0;
	echo ' Заказ: ';
	echo stripslashes($row2[0]);

	$result7 = mysql_query("select workers.employid from workers, orders where orders.orderid=workers.orderid and orders.orderid='$row2[0]'");

	while ($row5 = mysql_fetch_row($result7))
	{
		$an=$an+1;
	}

	$result11 = mysql_query("select amount from price where priceid='$an'");

	$row11 = mysql_fetch_row($result11);

	echo ' Оплата: ';
	echo $row11[0]/$an;
	echo '<br/> ';
}

?>
</div>
	</div>