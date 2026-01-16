<?php
require_once('assets/vendor/libs/BCG/BCGFontFile.php');
require_once('assets/vendor/libs/BCG/BCGDrawing.php');
require_once('assets/vendor/libs/BCG/BCGcode128.barcode.php');


$barcode=$_GET["barcode"];
//header('Content-Type: image/jpg');


$font = new BCGFontFile('assets/fonts/Arial.ttf', 10);
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);


// Barcode Part
$code = new BCGcode128();
$code->setScale(2);
$code->setThickness(25);
$code->setForegroundColor($color_black);
$code->setBackgroundColor($color_white);
$code->setFont($font);
$code->setStart(NULL);
$code->setTilde(true);
$code->parse($barcode);
	
// Drawing Part
$drawing = new BCGDrawing('', $color_white);
$drawing->setBarcode($code);
$drawing->draw();
header('Content-Type: image/jpeg');
$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);



imagejpeg($drawing->get_im());
//}
?>