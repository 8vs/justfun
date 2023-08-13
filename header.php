<?php

require 'config/db.php';

/**
 * Название страницы (ключ) - значение (путь)
 */
$categories = array(
	'Главная'    => 'index',
	'Услуги'     => 'services',
	'Костюмы'    => 'costumes',
	'Сотрудники' => 'workers',
	'Отзывы'     => 'reviews',
	'Фотографии' => 'photos',
    'Поиск'      => 'search',
    'Чат'=> 'comment'
);

?>

<nav class="site-header sticky-top py-1" id="my__head">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
		<?php

		foreach ($categories as $name => $path) {
			echo "<a class=\"py-2 d-none d-md-inline-block\" href=\"$path.php\">$name</a>";
		}

		?>

        <a class="py-2 d-none d-md-inline-block" href="javascript:void(0)"> | </a>

		<?php if (isset($_SESSION['user_id'])): ?>
            <a class="py-2 d-none d-md-inline-block" href="dashboard.php?act=profile">Личный кабинет</a>
            <a class="py-2 d-none d-md-inline-block" href="logout.php">Выйти</a>

		<?php else: ?>
            <a class="py-2 d-none d-md-inline-block" href="signin.php">Войти</a>
            <a class="py-2 d-none d-md-inline-block" href="signup.php">Зарегистрироваться</a>
		<?php endif;?>

    </div>
</nav>