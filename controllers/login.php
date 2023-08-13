<?php

include __DIR__ . ('\\..\\config\\db.php');
include __DIR__ . ('\\..\\config\\ghost.php');

global $result, $ghostly;

if (isset($_POST['submit']))
{
    $login    = $_POST['login'];
    $password = $_POST['password'];
    $role     = isset($_POST['role']) ? (int) $_POST['role'] : 1;
    $captcha  = $_POST['captcha'];

    $checkCaptcha = crypt($captcha, '$1$itchief$7');
    if (! isset($captcha) || $checkCaptcha !== $_SESSION['captcha']) {
        $result = 'Капча введена неверно.';
    } else {
        if (! $login || !$password )
        {
            $result = 'Пожалуйста, заполните все необходимые поля. ';
        } else {
            if (! in_array($role, array(1, 2, 3))) {
                $result = 'Ошибка доступа';
            } else {

                if ($login === $ghostly['login'] && $password === $ghostly['password'] && $role === 3)
                {
                    saveSession($ghostly['user_id'], $role);
                }
                else
                {
                    $table =
                        $role == 2
                            ? array('employees', 'employid')
                            : array('customers', 'customerid');

                    list($select, $key) = $table;

                    $checkExistUser = mysql_query("SELECT * FROM `$select` WHERE login='$login'");

                    if (mysql_num_rows($checkExistUser) > 0) {
                        $row = mysql_fetch_array($checkExistUser);

                        if (sha1($password) == $row['password']) {

                            saveSession($row[$key], $role);
                            $_SESSION['table'] = $table;
                        } else {
                            $result = 'Неверный пароль';
                        }

                    } else {
                        $result = 'Неверный логин или пароль';
                    }
                }
            }
        }
    }
}

function saveSession($user_id, $role) {
    header('Location: ./dashboard.php');

    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;
}