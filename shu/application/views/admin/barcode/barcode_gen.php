<? if ($this->uri->segment(3)) $barcode=$this->uri->segment(3); else exit();?>
<?
require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once('barcode_writer.php');

	header('Content-Type: image/png');
	barcode_generate($barcode);
	$barcode_image_source = imagecreatefromjpeg('barcode_temp.jpg');
	$image = imagecreatefromjpeg('barcode_temp.jpg');
	imagecopymerge($image, $barcode_image_source, 1430, 1450, 0,0,1002, 195,100);
 	imagejpeg($image);
?>