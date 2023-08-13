<?php

include ('__head.php');
include ('./controllers/register.php');
global $result;

?>

<html lang="ru">
<head>
    <title>Регистрация | Just Fun</title>
    <meta charset="UTF-8">
	
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

			<h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

			<input type="text" name="login" class="form-control" placeholder="Введите логин">
			
			<input type="password" name="password" class="form-control" placeholder="Введите пароль">
			
			<input type="text" name="name" class="form-control" placeholder="Введите ФИО">

            <input type="text" name="email" class="form-control" placeholder="Введите Email">    
			
			<input type="text" name="phone" class="form-control" placeholder="Введите телефон"> 
			
			<input type="text" name="city" class="form-control" placeholder="Введите город"> 

            <button type="submit" name="submit" id="submit" class="btn btn-lg btn-info btn-block">Регистрация</button>

        </form>
	</body>
</body>
</html>






