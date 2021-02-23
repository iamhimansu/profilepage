<?php
require_once __DIR__ . "/core.php";

$Captcha = new CodeFlirt\Handlers;
$captcha_text = $Captcha->generate_token('numeric', 8);

session_name("PP");
session_start();
//Clearing previous captcha problem
if (isset($_SESSION["captcha_problem"])) {
    unset($_SESSION["captcha_problem"]);
}
//Save Captcha in session

$_SESSION["captcha_problem"] = $captcha_text;

function generateCaptchaImage($text = 'good')
{
    // Set the content-type
    header('Content-Type: image/png');
    $width  = 150;
    $height = 30;
    // Create the image
    $im = imagecreatetruecolor($width, $height);

    // Create some colors
    $white  = imagecolorallocate($im, 255, 255, 255);
    $grey   = imagecolorallocate($im, 128, 128, 128);
    $black  = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 299, 29, $white);

    //ADD NOISE - DRAW background squares
    $square_count = 6;
    for ($i = 0; $i < $square_count; $i++) {
        $cx = rand(0, $width);
        $cy = (int)rand(0, $width / 2);
        $h  = $cy + (int)rand(0, $height / 5);
        $w  = $cx + (int)rand($width / 3, $width);
        imagefilledrectangle($im, $cx, $cy, $w, $h, $grey);
    }

    //ADD NOISE - DRAW ELLIPSES
    $ellipse_count = 10;
    for ($i = 0; $i < $ellipse_count; $i++) {
        $cx = (int)rand(-1 * ($width / 2), $width + ($width / 2));
        $cy = (int)rand(-1 * ($height / 2), $height + ($height / 2));
        $h  = (int)rand($height / 2, 2 * $height);
        $w  = (int)rand($width / 2, 2 * $width);
        imageellipse($im, $cx, $cy, $w, $h, $grey);
    }

    // Replace path by your own font path
    $font = __DIR__ . '/../../assets/fonts/Shadows_Into_Light/ShadowsIntoLight-Regular.ttf';

    // Add some shadow to the text
    imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

    // Add the text
    imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

    // Using imagepng() results in clearer text compared with imagejpeg()
    imagepng($im);
    imagedestroy($im);
}

generateCaptchaImage($captcha_text);
