<? 
if (isset($_GET["combine_id"])) $combine_id=$_GET["combine_id"]; else $combine_id =0;
require_once('config.php');
require_once('views/helper.php');

require_once('assets/vendor/libs/BCG/BCGFontFile.php');
require_once('assets/vendor/libs/BCG/BCGDrawing.php');
require_once('assets/vendor/libs/BCG/BCGcode128.barcode.php');
// require_once("barcode_writer.php");




header('Content-Type: image/png');
$sql = "SELECT * FROM box_combine WHERE combine_id='".$combine_id."'";

$result = mysqli_query($conn,$sql);


if (mysqli_num_rows($result)==1)
{
    $data = mysqli_fetch_array($result);
    
    $created_date=$data["created_date"];
		$receiver=$data["receiver"];
		$proxy=$data["proxy_id"];
		$proxy_type=$data["proxy_type"];
		$barcode=$data["barcode"];
		$package=$data["package"];
		$weight=$data["weight"];
		$sender = $data["sender"];
		
		$status=$data["status"];
   
		//SENDER 
		$sender_name=customer($sender,"full_name");
		$sender_address=customer($sender,"address");
		$sender_contact =customer($sender,"tel");
		//RECIEVER

		$receiver_name=customer($receiver,"full_name");
		$receiver_contact=customer($receiver,"tel");
		$receiver_address=customer($receiver,"address");

		//PROXY
		$proxy_name=proxy2($proxy,$proxy_type,"full_name");
		$proxy_contact=proxy2($proxy,$proxy_type,"tel");
		$proxy_address=proxy2($proxy,$proxy_type,"address");

   
        if ($package!="")
        {
            $package_array=explode("##",$package);
            if (count($package_array)>=3)  //PACKACGE ARRAY CHECK
            {
                @$package1_name = $package_array[0];
                @$package1_num = $package_array[1];
                @$package1_value = $package_array[2];
                @$package2_name = $package_array[3];
                @$package2_num = $package_array[4];
                @$package2_value = $package_array[5];
                @$package3_name = $package_array[6];
                @$package3_num = $package_array[7];
                @$package3_value = $package_array[8];
                @$package4_name = $package_array[9];
                @$package4_num = $package_array[10];
                @$package4_value = $package_array[11];
                $price=$package1_value+$package2_value+$package3_value+$package4_value;

                //$price=$package1_value+$package2_value+$package3_value+$package4_value;
                //$total_weight=$package1_weight+$package2_weight+$package3_weight+$package4_weight;

            }
            //echo $proxy;
            if (count($package_array)<10)  //PACKACGE ARRAY CHECK
            {
                $package1_name = "";
                $package1_num = "";
                $package1_value  = "";
                $package2_name  = "";
                $package2_num  = "";
                $package2_value  = "";
                $package3_name  = "";
                $package3_num  = "";
                $package3_value  = "";
                $package4_name  = "";
                $package4_num  = "";
                $package4_value = "";

            }
        }

        barcode_generate($barcode);
    
    
        ini_set('memory_limit', '-1');
        $font='assets/fonts/Arial.ttf';
        $font_size=15;
        $cp72Path ='assets/img/cp72.jpg';
        $image = imagecreatefromjpeg($cp72Path);
        $color = imagecolorallocate($image, 0, 0, 0);
        $barcode_image_source = imagecreatefromjpeg('assets/img/barcode_temp.jpg');
        $logo_image_source = imagecreatefromjpeg('assets/img/logo.jpg');

        imagettftext($image,$font_size,0,79,90,$color,$font,$sender_name);
	imagettftext($image,$font_size,0,255,195,$color,$font,$sender_contact);
	imagettftext($image,$font_size,0,79,120,$color,$font,substr($sender_address,0,18));
	imagettftext($image,$font_size,0,79,140,$color,$font,substr($sender_address,36,18));
	imagettftext($image,$font_size,0,79,160,$color,$font,substr($sender_address,52,18));
	
	if ($proxy==0)
	{
	imagettftext($image,$font_size,0,490,93,$color,$font,$receiver_name);
	imagettftext($image,$font_size,0,400,192,$color,$font,$receiver_contact);
	imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($receiver_address,0,36));
	imagettftext($image,$font_size-5,0,450,130,$color,$font,substr($receiver_address,36,36));
	imagettftext($image,$font_size-5,0,450,160,$color,$font,substr($receiver_address,72,36));
	}
	
	if ($proxy!=0)
	{
	imagettftext($image,$font_size,0,490,93,$color,$font,$proxy_name);
	imagettftext($image,$font_size,0,400,192,$color,$font,$proxy_contact);
	imagettftext($image,$font_size,0,500,192,$color,$font,"/99");
	imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($proxy_address,0,36));
	imagettftext($image,$font_size-5,0,450,130,$color,$font,substr($proxy_address,36,36));
	imagettftext($image,$font_size-5,0,450,160,$color,$font,substr($proxy_address,72,36));
	}


	if ($package!="")
	{
	imagettftext($image,$font_size,0,20,280,$color,$font,$package1_name);
	imagettftext($image,$font_size,0,20,305,$color,$font,$package2_name);
	imagettftext($image,$font_size,0,20,330,$color,$font,$package3_name);
	imagettftext($image,$font_size,0,20,355,$color,$font,$package4_name);
	
	imagettftext($image,$font_size,0,210,280,$color,$font,$package1_num);
	imagettftext($image,$font_size,0,210,305,$color,$font,$package2_num);
	imagettftext($image,$font_size,0,210,330,$color,$font,$package3_num);
	imagettftext($image,$font_size,0,210,355,$color,$font,$package4_num);
	
	
	/*imagettftext($image,$font_size,0,720,280,$color,$font,$package1_produced);
	imagettftext($image,$font_size,0,720,305,$color,$font,$package1_produced);
	imagettftext($image,$font_size,0,720,330,$color,$font,$package1_produced);
	imagettftext($image,$font_size,0,720,355,$color,$font,$package1_produced);
	
	imagettftext($image,$font_size,0,940,280,$color,$font,$package1_weight);
	imagettftext($image,$font_size,0,940,305,$color,$font,$package2_weight);
	imagettftext($image,$font_size,0,940,330,$color,$font,$package3_weight);
	imagettftext($image,$font_size,0,940,355,$color,$font,$package4_weight);*/
	
	imagettftext($image,$font_size,0,430,280,$color,$font,$package1_value);
	imagettftext($image,$font_size,0,430,305,$color,$font,$package2_value);
	imagettftext($image,$font_size,0,430,330,$color,$font,$package3_value);
	imagettftext($image,$font_size,0,430,355,$color,$font,$package4_value);
	
	//imagettftext($image,$font_size,0,380,375,$color,$font,$price);
	}
	
	
	imagettftext($image,$font_size,0,800,70,$color,$font,$weight);
	imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price($weight)."$");
	//imagettftext($image,$font_size,0,1100,1040,$color,$font,$price."$");
	
	imagettftext($image,$font_size,0,280,480,$color,$font,str_replace('-','  ',substr($created_date,0,10)));
	imagettftext($image,$font_size+5,0,780,340,$color,$font,str_replace(':',' :  ',substr($created_date,10,6)));
	

	imagettftext($image,$font_size,0,510,510,$color,$font,"Combined ");
	

	imagecopymerge($image, $barcode_image_source, 550, 530, 0,0,334, 63,100);
	// imagecopymerge($image, $logo_image_source, 785, 370, 0,0,110, 110,100);
	

 	imagejpeg($image);
	
}
?>