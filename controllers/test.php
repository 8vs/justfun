<?php

include __DIR__ . ('\\..\\config\\db.php');


$added = mysql_query("SELECT * FROM orders");

print_r(mysql_fetch_assoc($added));