<?php

$connect = new PDO("mysql:host=localhost;dbname=justfun", "root", "");

if(isset($_POST["categorys"]))
{
	$query = "SELECT category_serv.categoty_name, category_serv.categoryid, count(category_serv.categoryid) FROM category_serv, services, order_items, orders WHERE services.serviceid=order_items.serviceid AND order_items.orderid=orders.orderid AND category_serv.categoryid=services.categoryid AND customerid='".$_POST["categorys"]."' group by customerid, categoryid";

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
 
	foreach($result as $row)
	{
		$output[] = array(
			'title'   => $row["categoty_name"],
			'amount'  => (float)($row["count(category_serv.categoryid)"])
		);
	}
 
	echo json_encode($output);
}

?>