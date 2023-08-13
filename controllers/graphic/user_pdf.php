<?php

require __DIR__ . './../utils/PDFController.php';
require __DIR__ . './../../config/db.php';

if (isset($_GET['meta']))
{
    $meta = json_decode($_GET['meta'], true);

    $pdf = new MyPDF_NEXT('L', 'mm', 'A4', true, 'UTF-8', false);

//    $pdf->setters(
//        array(
//            'result' => isset($meta['amount']),
//            'summary' => +$meta['amount'],
//            'keys' => $meta['keys']
//        )
//    );

    $user = $_SESSION['user_id'];
    $name = '';
    $meta_text = 'Отчет';

    if (isset($user) || $user !== -1) {
        $checkExistUser = mysql_query("SELECT * FROM customers WHERE customerid='$user'");
        $row = mysql_fetch_array($checkExistUser);
        $name = $row['name'];
        $meta_text = "Отчет составлен по данным пользователя $name";
    }

    // Адаптация <br>
    foreach ($meta['values'] as $k => &$value) {
         $value = preg_replace('/\n{2,}/', "\r\n", $value);
        // $value = preg_replace('/\n|[\n\t\s]{2,}/', "%", $value);

    }

    $pdf->AddPage();

    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',14);
    $pdf->SetWidths(array(30,50,30,40, 50));


    for ($i = 0; $i < 20; $i++) {
        $pdf->Row($meta['values'][$i]);
    }

    $pdf->Output();


        // $pdf->Output();


    // $pdf->createData($meta['values'], $meta_text);
}