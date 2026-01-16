<? if ($this->uri->segment(3)) $barcode=$this->uri->segment(3); else exit();?>
<?
require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");
barcode_generate($barcode);
	header('Content-Type: image/png');
	//barcode_generate($barcode);
	$barcode_image_source = imagecreatefromjpeg('barcode_temp.jpg');
	$image = imagecreate (340 , 69 );
	$white = imagecolorallocate($image, 255, 255, 255);
	imagecopymerge($image, $barcode_image_source, 2,0, 0,0,334, 63,100);
 	imagejpeg($image);
?>