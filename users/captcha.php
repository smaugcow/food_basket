<?php
session_start();

header("Content-type: image/png");

require_once '../includes/funcs.php';

$image = imagecreate(60, 20);

// Генерация случайного фона
$background_color = imagecolorallocate($image, 255, 255, 255);

// Генерация случайного текста
$text_color = imagecolorallocate($image, 0, 0, 0);
$captcha_text = generate_random_text();
$_SESSION['captcha_text'] = $captcha_text;

imagestring($image, 5, 3, 3, $captcha_text, $text_color);

imagepng($image);
imagedestroy($image); 
?>
