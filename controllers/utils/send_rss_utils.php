<?php

set_time_limit(0);
ignore_user_abort(1);

function sending($message, $data) {
	foreach ($data as $email) mail($email, 'Рассылка от JustFun', $message);
}