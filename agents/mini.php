<?php 
if (isset($_GET["id"])) $order_id=$_GET["id"]; else $order_id =0;
require_once('config.php');
require_once('views/helper.php');

require_once('assets/vendor/libs/BCG/BCGFontFile.php');
require_once('assets/vendor/libs/BCG/BCGDrawing.php');
require_once('assets/vendor/libs/BCG/BCGcode128.barcode.php');


header('Content-Type: image/png');

$sql = "SELECT * FROM orders WHERE order_id=".$order_id;
$result = mysqli_query($conn,$sql);


if (mysqli_num_rows($result)==1)
{
    $data = mysqli_fetch_array($result);
    

   		$created_date=$data["created_date"];
		$order_id=$data["order_id"];
		$barcode=$data["barcode"];
		$status=$data["status"];
		$receiver=$data["receiver"];
		$third_party=$data["third_party"];
		
	//CLEAR PROXY
    mysqli_query($conn,"UPDATE orders SET proxy_id='0' WHERE order_id=".$order_id);
	
	//CLEAR PROXY
		//$proxy=$data["proxy_id;
   
		//RECIEVER
		$receiver_name=customer($receiver,"full_name");
		$receiver_contact=customer($receiver,"tel");
		$receiver_address=customer($receiver,"address");
        barcode_generate($barcode);


        ini_set('memory_limit', '-1');
        $font='assets/fonts/Arial.ttf';
        $font_size=15;
        //$cp72Path ='assets/images/cp72.jpg';
        $image = imagecreate (800 , 200 );
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $color = imagecolorallocate($image, 0, 0, 0);
        $barcode_image_source = imagecreatefromjpeg('assets/img/barcode_temp.jpg');

        //$logo_image_source = imagecreatefromjpeg('assets/images/logo.jpg');
        
        
        imagettftext($image,$font_size,0,20,140,$color,$font,$receiver_name);
        imagettftext($image,$font_size,0,20,160,$color,$font,$receiver_contact);
        //if ($proxy!="") imagettftext($image,$font_size+10,0,20,60,$color,$font,proxy($proxy,'name'));
        //if ($proxy!="") imagettftext($image,$font_size+10,0,20,100,$color,$font,proxy($proxy,'tel'));

        
        imagettftext($image,$font_size,0,400,60,$color,$font,"Track: ".$third_party);

        imagecopymerge($image, $barcode_image_source, 400, 100, 0,0,334, 63,100);
        

        imagejpeg($image);
	
   }
  ?>