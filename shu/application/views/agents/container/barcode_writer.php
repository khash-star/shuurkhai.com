<?
function barcode_generate($text)
{
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
    $code->parse($text);
     
    // Drawing Part
    $drawing = new BCGDrawing('barcode_temp.jpg', $color_white);
    $drawing->setBarcode($code);
    $drawing->draw();
    //header('Content-Type: image/jpeg');
    $drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
}





?>