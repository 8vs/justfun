<style>
	.reviews-block {
    border: 2px solid #17a2b8;
	border-radius: 8px;
    margin: 20px;
	background: #F5FFFA;
}

.reviews-block > div.item {
    color: #87CEFA;
    padding: 10px;
}

.reviews-block > div.item > p {
    text-align: right;
}

.reviews-img {
    height: 45px;
    text-align: left;
    border-radius: 50%;
}

.span {
    color: #17a2b8;
}
</style>

<?php

global $result;
$query = mysql_query("SELECT customers.name, reviews.review, reviews.date_rew FROM customers, reviews WHERE customers.customerid = reviews.customerid;");
$user = $_SESSION['user_id'];

?>

<p> </p>

<?php if (isset($user) && $_SESSION['role'] === 1): ?>
    <div class="container marketing">
        <form action="" method="post">

	        <form method="post" action="" class="pt-lg-4">
			<?php if (! empty($result)) echo '<div id="result">'. $result .'</div>'; ?>

            <div class="form-group">
                <label for="question"></label>
                <input type="text" class="form-control" name="text" placeholder="Здесь введите ваш отзыв">
            </div>

            <button type="submit" name="submit" id="submit" class="btn btn-info">Оставить отзыв</button>
        </form>

        </form>
    </div>

    

<?php else: ?>
<div class="container marketing">
    <p><?= (isset($user)) ? 'Нет доступа для оставления отзыва.' : 'Чтобы оставить отзыв, пожалуйста, авторизируйтесь.'?></p>
</div>
<?php endif; ?>

<div class="container marketing">
        <?php while ($row = mysql_fetch_array($query)): ?>

            <div class="reviews-block">
                <div class="item">
                    <img src="../../assets/images/otz.jpg" class="reviews-img" alt="otz">
                    <div class="span"><?= $row['name']; ?></div>
                    <p><?= $row['review']; ?></p>
                    <p class="span">Отзыв был написан <?= $row['date_rew']; ?> </p>
                </div>
            </div>

        <?php endwhile; ?>
    </div>