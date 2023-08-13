<?php

$connect = new PDO("mysql:host=localhost;dbname=justfun", "root", "");

if(isset($_POST["categorys"]))
{
 $query = "SELECT sum(services.amount), month(orders.date_ord) FROM orders, order_items, services  where orders.orderid=order_items.orderid and order_items.serviceid=services.serviceid and  year(orders.date_ord)='".$_POST["categorys"]."' group by month(orders.date_ord)";
 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 
 foreach($result as $row)
 {
  $output[] = array(
   'title'   => $row["month(orders.date_ord)"],
   'amount'  => (float)($row["sum(services.amount)"])
  );
 }
 
 echo json_encode($output);
}

?>