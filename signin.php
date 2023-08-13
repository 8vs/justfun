<?php

include ('__head.php');
include ('./controllers/login.php');
global $result;

?>

<html lang="ru">
<head>
    <title> Авторизация | Just Fun</title>
    <meta charset="UTF-8">
	
	<style>
		html, body { height: 100%; }
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
		.form-signin .checkbox { font-weight: 400; }
		.form-signin .form-control {
		  position: relative;
		  box-sizing: border-box;
		  height: auto;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus { z-index: 2; }
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
		
		.wrapper_inpt {
		  width: 300px;
		  height: 40px;
		  border-radius: 20px;
		  border: 1px solid #d1d1d1;
		  display: flex;
		  justify-content: space-between;
		  align-items: center;
		  padding: 2px;
		}
		.btn_area {
		  width: 56px;
		  height: 36px;
		  background: #4ba025;
		  border-radius: 20px;
		  color: #fff;
		  font-size: 1.3em;
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  cursor: pointer;
		}
		input {
		  border: none;
		  background: none;
		  width: calc(100% - 84px);
		  height: 100%;
		  text-indent: 10px;
		}
	</style>
</head>
<body>
    <?php

    include ('header.php');

    if (isset($_SESSION['user_id'])) {
        header('Location: ./dashboard.php?act=profile');
    }

    ?>

	<body class="text-center">
		<form action="" method="post" class="form-signin">

            <?php if (! empty($result)) echo '<div id="result" class="alert alert-info">'. $result .'</div>'; ?>

			<h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
			
			<label for="inputEmail" class="sr-only">Логин</label>
			<input type="text" name="login" class="form-control" placeholder="Введите логин">
			
			<label for="inputPassword" class="sr-only">Пароль</label>
			<input type="password" name="password" class="form-control" placeholder="Введите пароль">
			
			<div class="form-group">
                <select name="role" class="form-control">
					<option disabled selected value>  -- Сделайте выбор --  </option>
                    <option value="1">Пользователь</option>
                    <option value="2">Сотрудник</option>
                    <option value="3">Администратор</option>
                </select>
            </div>
			
			<!-- Сообщение которое будем показывать при успешной отправки формы -->
			<div class="form-result d-none">Форма успешно отправлена!</div>



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

            <button type="submit" name="submit" id="submit" class="btn btn-lg btn-info btn-block">Войти</button>

        </form>
	</body>
	
	<script>
    const refreshCaptcha = (target) => {
        const captchaImage = target.closest('.captcha__image-reload').querySelector('.captcha__image');
        captchaImage.src = '/assets/php/captcha.php?r=' + new Date().getUTCMilliseconds();
    }

    const captchaBtn = document.querySelector('.captcha__refresh');
    captchaBtn.addEventListener('click', (e) => refreshCaptcha(e.target));

  </script>
	
</body>
</html>













