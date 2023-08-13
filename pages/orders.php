<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 

<?php

$user = $_SESSION['user_id'];

/* Список всех сервисов */
function getAllServices() {
	$items = array();

	$pack = mysql_query('SELECT * FROM services');

	while ($row = mysql_fetch_array($pack)) {
		$items[] = $row;
	}

	return $items;
}

/* Поиск всех деталей заказа по orderid */
function getItemsByOid($oid) {
    $items = array();

	$pack = mysql_query("SELECT serviceid FROM order_items WHERE orderid='$oid'");

    while ($row = mysql_fetch_array($pack)) {
        $items[] = $row['serviceid'];
    }

    return $items;
}

/* Поиск всех фото по customerid  */
function getAllPhotosByCid() {
    global $user;

	$pack = mysql_query("SELECT * FROM photos WHERE customerid='$user'");

	$items = array();
	while ($row = mysql_fetch_array($pack)) {
		$items[] = $row;
	}

	return $items;
}

/* Поиск сервиса по serviceid */
function getServByIds($list) {
    $services = getAllServices();

    $result = array();
    foreach ($list as $item) {
        foreach ($services as $value) {
            if ($value['serviceid'] === $item) {
                $result[] = $value;
            }
        }
    }

    return $result;
}

/* Поиск всех фото user_id по нужной дате */
function getPhotoByDate($date) {
    $photos = getAllPhotosByCid();

    $result = array();
    foreach ($photos as $item) {
        if ($item['date_photo'] === $date) {
            $result[] = $item;
        }
    }

    return $result;
}

$allOrders = mysql_query("SELECT * FROM orders WHERE customerid='$user'");

$orders = array();
while ($row = mysql_fetch_array($allOrders))
{
    /* Добавляем элементы заказа в заказ */
	$items = getItemsByOid($row['orderid']);
    $row['items'] = getServByIds($items);
    /* --------------------------------- */

	/* Сопоставление фотографий в зависимости от даты */
    $row['photos'] = getPhotoByDate($row['date_ord']);
	/* ---------------------------------------------- */

	$orders[$row['orderid']] = $row;
}

$globalAmounts = 0;

$keys = array(
        '№ заказа',
        'Название',
        'Адрес',
        'Сумма',
        'Дата',
//        'Фото'
);

?>

<div class="d-flex justify-content-center">
    <h5>Количество заказов <span id="other_count" class="badge badge-info"><?= count($orders); ?></span></h5>
</div>

    <?php if (count($orders) === 0): ?>
        <p>У вас ещё нет заказов.</p>
    <?php else: ?>

        <table id="user-stat-orders" class="table table-striped">
            <thead>
                <tr>
                    <?php foreach ($keys as $val): ?>
                        <th><?= $val; ?></th>
                    <?php endforeach; ?>

                </tr>
            </thead>
            <tbody>
       <?php foreach ($orders as $order): ?>

		   <?php

		   /* Цикличная обработка деталей заказа */
		   $amounts = 0;
		   $titles = array();

		   foreach ($order['items'] as $value) {
			   $amounts += $value['amount'];
			   $titles[] = $value['title'];
		   }

		   $globalAmounts += $amounts;
		   /* ---------------------------------- */
		   ?>

           <tr>
               <td class="tg-0lax"><?= $order['orderid']; ?></td>
               <td class="tg-0lax"><?= join(', ', $titles); ?></td>
               <td class="tg-0lax"><?= $order['place']; ?></td>
               <td class="tg-0lax"><?= $amounts; ?></td>
               <td class="tg-0lax"><?= $order['date_ord']; ?> <?= $order['time']; ?></td>

<!--               <td>-->
<!--                   --><?php //if (count($order['photos']) === 0): ?>
<!--                        <p>Фото нет</p>-->
<!--                   --><?php //else: ?>
<!---->
<!--					   --><?php //foreach ($order['photos'] as $val):
//                           ?>
<!--                           <img width="400"-->
<!--                                   alt="photo_--><?//= $order['orderid']; ?><!--"-->
<!--                                   src="/assets/images/photos/--><?//= $user; ?><!--/--><?//= $val['photo']; ?><!--"-->
<!--                           >-->
<!--<p> </p>-->
<!--					   --><?php //endforeach; ?>
<!---->
<!--                   --><?php //endif; ?>
<!---->
<!--               </td>-->

           </tr>
       <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            <button class="btn btn-info" onclick="getResult();">Создать отчет</button>
        </div>

        <input id="globalAmount" type="hidden" value="<?php global $globalAmounts; echo $globalAmounts ?>"/>
    <?php endif; ?>
  <br><br>

		
		
<script>
    function getResult() {
        const table = '#user-stat-orders';
        const keys = [];
        const values = [];
        const amount = $('#globalAmount').val();
        $(`${table } > thead > tr`).map((_, e) => keys.push(e.innerText.split(`\t`)));
        $(`${table } > tbody > tr`).map((_, e) => values.push(e.innerText.split(`\t`)));


        console.log(keys, values)

        window.open('/controllers/graphic/workers_pdf.php?meta='+encodeURIComponent(JSON.stringify({
            keys,
            values,
            amount
        })), '_blank').focus();
        // document.location = '/controllers'
    }
</script>