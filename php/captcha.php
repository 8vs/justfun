<?php

$chars = join('', range('a', 'z'));
$length = 4;
$code = substr(str_shuffle($chars), 0, $length);

session_start();
$_SESSION['captcha'] = crypt($code, '$1$itchief$7');
session_write_close();

$image = imagecreatefrompng(__DIR__ . '/files/bg.png');
$size = 36;
$color = imagecolorallocate($image, 66, 182, 66);
$font = __DIR__ . '/files//oswald.ttf';
$angle = rand(-10, 10);
$x = 56;
$y = 64;

imagefttext($image, $size, $angle, $x, $y, $color, $font, $code);

header('Cache-Control: no-store, must-revalidate');
header('Expires: 0');
header('Content-Type: image/png');

imagepng($image);
imagedestroy($image);
