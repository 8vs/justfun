<?php

ob_start();

require __DIR__ . './../utils/PDFController.php';
require __DIR__ . './../../config/db.php';

if (isset($_GET['meta']))
{
    $meta = json_decode($_GET['meta'], true);

    $pdf = new PDFController('L');

    $pdf->setters(
        array(
            'result' => isset($meta['amount']),
            'summary' => +$meta['amount'],
            'keys' => $meta['keys']
        )
    );

    $user = $_SESSION['user_id'];
    $name = '';
    $meta_text = 'Отчет';

    if (isset($user)) {

        if ($user != '-1') {
            $checkExistUser = mysql_query("SELECT * FROM customers WHERE customerid='$user'");
            $row = mysql_fetch_array($checkExistUser);
            $name = $row['name'];
        } else {
            $name = 'администратора';
        }

        $meta_text = "Отчет составлен из личного кабинета $name";
    }

    // Адаптация <br>
     foreach ($meta['values'] as $k => &$value) $value = preg_replace('/\n/', ' ', $value);

    $pdf->createData($meta['values'], $meta_text);

    $pdf->Output();
}

ob_end_flush();