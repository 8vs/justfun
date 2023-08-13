<?php

function sendMail($to, $tema, $message, $from) {
	$send = mail($to, $tema, $message, $from);
	
	if ($send) {
		return true;
	}
	
	return false;
}
