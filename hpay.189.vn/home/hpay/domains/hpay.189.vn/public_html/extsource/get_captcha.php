<?php
session_start();

$word_1 = '';

for ($i = 0; $i < 4; $i++) 
{
	$word_1 .= chr(rand(97, 122));
}
for ($i = 0; $i < 4; $i++) 
{
	$word_2 .= chr(rand(97, 122));
}

$_SESSION['code'] = $word_1.' '.$word_2;

$dir = 'fonts/';

$image = imagecreatetruecolor(180, 50);

$font = "recaptchaFont.ttf"; // font style

$color = imagecolorallocate($image, 0, 0, 0);// color

$white = imagecolorallocate($image, 255, 255, 255); // background color white

imagefilledrectangle($image, 0,0, 709, 99, $white);

imagettftext ($image, 22, 0, 5, 30, $color, $dir.$font, $_SESSION['code']);

header("Content-type: image/png");

imagepng($image);  ?>