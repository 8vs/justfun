<?php include ('./controllers/reset.php'); ?>

<style>
	html,
	body {
		height: 100%;
	}
	body {
		-ms-flex-align: center;
		-ms-flex-pack: center;
		-webkit-box-align: center;
		align-items: center;
		-webkit-box-pack: center;
		justify-content: center;
	}
	.form-signin {
		width: 100%;
		max-width: 330px;
		padding: 15px;
		margin: 0 auto;
	}
	.form-signin .checkbox {
		font-weight: 400;
	}
	.form-signin .form-control {
		position: relative;
		box-sizing: border-box;
		height: auto;
		padding: 10px;
		font-size: 16px;
	}
	.form-signin .form-control:focus {
		z-index: 2;
	}
	.form-signin input[type="email"] {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}
	header.title, h4:after, h5:after, h6:after {
    display: table;
    width: 100%;
    content: " ";
    margin-top: -1px;
    border-bottom: 1px dotted;
}
</style>

<?php

$user = $_SESSION['user_id'];
$role = $_SESSION['role'];

$roleNames = array('Пользователь', 'Сотрудник', 'Администратор');

$name = 'Ghost';
$email = 'Отсутствует';

if ($role < 3) {
	list($select, $key) = $_SESSION['table'];

	$checkExistUser = mysql_query("SELECT * FROM `$select` WHERE $key='$user'");
	$row = mysql_fetch_array($checkExistUser);

    $name = $row['name'];
    $email = $row['email'];
	$phone = $row['phone'];
	$login = $row['login'];
}

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Личные данные</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">История активности</a>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active mb-auto" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<form action="" method="post">
			<?php if ($role < 3) { 

				if (! empty($result)) echo '<div id="result" class="alert alert-info">'. $result .'</div>'; ?>

				<h5 class="mb-3 font-weight-normal">Измнить личные данные (заполните поля, которые хотите изменить)</h5>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Логин:</span>
					<input type="text" name="login" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="<?= $login; ?>">
				</div>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Имя:</span>
					<input type="text" name="name"  class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="<?= $name; ?>">
				</div>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Почта:</span>
					<input type="text" name="email"  class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="<?= $email ; ?>">
				</div>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Номер:</span>
					<input type="text" name="phone"  class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="<?= $phone; ?>">
				</div>
				
				<h5 class="mb-3 font-weight-normal">Изменить пароль (заполните все поля)</h5>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Введите старый пароль:</span>
					<input type="password" name="old_password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
				</div>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Введите новый пароль:</span>
					<input type="password" name="new_password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
				</div>
				
				<div class="input-group input-group-sm mb-3">
					<span class="input-group-text" id="inputGroup-sizing-sm">Повторите новый пароль:</span>
					<input type="password" name="newnew_password" class="form-control"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
				</div>
				
				<br></br><br>
				
				<div class="captcha" style="">
					<div class="captcha__image-reload">
						<div class="form-group">
							<img class="captcha__image" src="/assets/php/captcha.php" width="132" alt="captcha">
							<button type="button" class="captcha__refresh">↺</button>
						</div>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" name="captcha" id="captcha" placeholder="Введите код с картинки">
					</div>
				</div>
				
				
				<button type="submit" name="submit" id="submit" class="btn btn-info form-control">Сохранить изменения</button>
				
				<br></br>
				<button type="submit" name="delete" id="delete" class="btn btn-danger form-control">Удалить учётную запись</button>

			<?php } ?>
		</form>
	</div>

    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
		<script>
		$.getJSON('http://www.geoplugin.net/json.gp?jsoncallback=?', function(data) {
			console.log(JSON.stringify(data, null, 2));
		});
		</script>
	</div>