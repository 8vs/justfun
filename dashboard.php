<html lang="ru">
<head>
    <title> Личный кабинет | Just Fun</title>
	<?php include ('__head.php'); ?>
</head>

<body>

<?php include ('header.php'); ?>

<div class="container pt-5">
	<?php

	if (! isset($_SESSION['user_id']) || ! isset($_SESSION['role']) ) {
		header('Location: /signin.php');
	}

	/*  ---------------- роутер доступа к страницам ----------- */
	$public = array(
	);

	$private = array(
		1 => array(
			'profile' => 'Мой профиль',
			'cart'   => 'Сделать заказ',
			'orders' => 'Заказы',
			'feedback' => 'Обратная связь'
		),
		2 => array(
			'reservation' => 'Обработка заказов',
			'counters' => 'Статистика'
		),
		3 => array(
			'list_table' => 'Управление БД',
			'rss' => 'Рассылка',
            'statistic' => 'Статистика'
		)
	);

	$act = isset($_GET['act']) ? $_GET['act'] : 'profile';

	$accessPaths = array_merge(
		array_keys($public),
		array_keys( $private[$_SESSION['role']] )
	);

//	if (! in_array($act, $accessPaths)) {
//		header('Location: /dashboard.php?act=profile');
//	}

	/*  ---------------- роутер доступа к страницам ----------- */

	$menu = array_merge($public, $private[$_SESSION['role']]);

	?>

    <div class="row">

        <div class="col-3">
            <div class="list-group">
				<?php foreach ($menu as $path => $name): ?>
                    <a href="?act=<?= $path; ?>" class="list-group-item list-group-item-action"><?= $name; ?></a>
				<?php endforeach; ?>

            </div>
        </div>

        <div class="col-9">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"> <?= $menu[$act]; ?> </li>
                </ol>
            </nav>


            <?php

			if ($act)
			{
				$path = 'pages/' . $act . '.php';

				if (file_exists($path) && is_file($path)) {
					include $path;
				} else {
					echo '<p>Не удалось загрузить информацию о странице.</p>';
				}
			}

			?>
        </div>

    </div>

</div>

</body>
</html>
