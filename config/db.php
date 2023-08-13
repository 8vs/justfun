<?php

//// Заголовки/буфер
//ob_start();

if (! isset($_SESSION)) {
    // Устанавливаем сессию
    session_start();
}

$hostname = '127.0.0.1';
$username = 'root';
$password = '';
$dbname   = 'justfun';

$connection = mysql_connect($hostname, $username, $password) or die ('Соединение с базой данных не установлено.');
mysql_select_db($dbname);