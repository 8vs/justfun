<?php

include '../../config/db.php';

// Импортируем функции для вывода
require 'api_helpers.php';

/* Проверка авторизации и доступа */
if (! isset($_SESSION['user_id'])) {
	fail('Access denied.');
}

function getList()
{
	$data = array();
    $getList = mysql_query('SELECT * FROM employees');

    $allowed = array('employid', 'name');

	while ($row = mysql_fetch_assoc($getList)) {
        $data[] = array_intersect_key($row, array_flip($allowed));
	}

    return $data;
}

function groupByAnimators()
{
    $data = getList();

    $result = array();
    foreach ($data as $animator)
    {
        $result[] = array(
            'employid' => $animator['employid'],
            'name' => $animator['name'],
            'orders' => getWorkersById($animator['employid'])
        );
    }

    return $result;
}

function getWorkersById($id)
{
    $query = mysql_query("SELECT workers.orderid
FROM   workers,
       orders
WHERE  orders.orderid = workers.orderid
       AND workers.employid = '$id'
       AND orders.date_ord <= CURRENT_DATE");

    $data = array();

    while ($row = mysql_fetch_assoc($query)) {
        $data[] = +$row['orderid'];
    }

    return $data;
}

$method = $_GET['method'];

if (isset($_GET) && isset($method))
{
    switch ($_GET['method']) {
        case 'groupByAnimators':
            $data = groupByAnimators();
            success($data);
            break;

        default:
            fail('Не найден метод');
            break;
    }

}