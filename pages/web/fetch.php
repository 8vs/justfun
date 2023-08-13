<?php

$connect = new PDO("mysql:host=localhost;dbname=justfun", "root", "");

if(isset($_POST["categorys"]))
{
 $query = "SELECT * FROM services, category_serv WHERE category_serv.categoty_name = '".$_POST["categorys"]."' and services.categoryid=category_serv.categoryid";
 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 
 foreach($result as $row)
 {
  $output[] = array(
   'title'   => $row["title"],
   'amount'  => (float)($row["amount"])
  );
 }
 
 echo json_encode($output);
}

?>