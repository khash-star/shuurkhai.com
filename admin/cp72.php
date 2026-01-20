<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET["id"])) $order_id = intval($_GET["id"]); else $order_id = 0;
require_once('config.php');
require_once('views/helper.php');

require_once('assets/vendors/BCG/BCGFontFile.php');
require_once('assets/vendors/BCG/BCGDrawing.php');
require_once('assets/vendors/BCG/BCGcode128.barcode.php');
// require_once("barcode_writer.php");

if ($order_id <= 0) {
    header('Content-Type: text/html; charset=utf-8');
    die("Алдаа: Захиалгын ID буруу байна.");
}

$sql = "SELECT * FROM orders WHERE order_id=".$order_id;
$result = mysqli_query($conn,$sql);

if (!$result) {
    header('Content-Type: text/html; charset=utf-8');
    die("Алдаа: Өгөгдлийн сангийн алдаа: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) != 1) {
    header('Content-Type: text/html; charset=utf-8');
    die("Алдаа: Захиалга олдсонгүй (ID: ".$order_id.")");
}

// Check required files before setting image header
$cp72Path = 'assets/img/cp72.jpg';
$logo_path = 'assets/img/logo.jpg';
$font_path = 'assets/fonts/Arial.ttf';

if (!file_exists($cp72Path)) {
    header('Content-Type: text/html; charset=utf-8');
    die("Алдаа: CP72 загварын зураг олдсонгүй: ".$cp72Path);
}

if (!file_exists($font_path)) {
    header('Content-Type: text/html; charset=utf-8');
    die("Алдаа: Фонт файл олдсонгүй: ".$font_path);
}

// All checks passed, now set image header  
header('Content-Type: image/jpeg');

if (mysqli_num_rows($result)==1)
{
    $data = mysqli_fetch_array($result);
    
   		$created_date=$data["created_date"];
		$order_id=$data["order_id"];
  	 	$sender=$data["sender"];
   		$receiver=$data["receiver"];
        $proxy=$data["proxy_id"];
        $proxy_type=$data["proxy_type"];
   
           
		$barcode=$data["barcode"];
		$package=$data["package"];
		$weight=$data["weight"];
		$price=$data["price"];
		$way=$data["way"];
		$inside=$data["inside"];
		$deliver_time=$data["deliver_time"];
		$return_type=$data["return_type"];
		$return_day=$data["return_day"];
		$return_way=$data["return_way"];
		$return_address=$data["return_address"];
		$status=$data["status"];
		$insurance=$data["insurance"];
		$insurance_value = isset($data["insurance_value"]) ? $data["insurance_value"] : 0;
        $third_party = $data["third_party"];
   
   		//SENDER 

			$sender_name=customer($sender,"name");
			$sender_contact=customer($sender,"tel");
			$sender_address=customer($sender,"address");
		
		

		//RECIEVER
		
			$receiver_name=customer($receiver,"name");
			$receiver_contact=customer($receiver,"tel");
			$receiver_address=customer($receiver,"address");

            $sql_reciever = "SELECT customer.*,city.name AS city_name,district.name AS district_name FROM customer 
            LEFT JOIN city ON customer.address_city=city.id 
            LEFT JOIN district ON customer.address_district=district.id 
            WHERE customer_id='$receiver' LIMIT 1";
            $result_receiver = mysqli_query($conn,$sql_reciever);
            if (mysqli_num_rows($result_receiver)==1)
            {
                $data_receiver = mysqli_fetch_array($result_receiver);            
                $receiver_name=$data_receiver["name"];
                $receiver_contact=$data_receiver["tel"];
                $receiver_address=$data_receiver["address"];
                $receiver_address_city=$data_receiver["address_city"];
                $receiver_address_city_name = $data_receiver["city_name"];
                $receiver_address_district=$data_receiver["address_district"];
                $receiver_address_district_name=$data_receiver["district_name"];
                $receiver_address_khoroo=$data_receiver["address_khoroo"];
                $receiver_address_build=$data_receiver["address_build"];
                if ($receiver_address_district<>"" && $receiver_address_khoroo<>"")
                $receiver_address = $receiver_address_city_name." ".$receiver_address_district_name.", ".$receiver_address_khoroo."-р хороо".$receiver_address_build;
            }
            else 
            {
                $receiver_address="";
                $receiver_address_city="";
                $receiver_address_city_name = "";
                $receiver_address_district="";
                $receiver_address_district_name="";
                $receiver_address_khoroo="";
                $receiver_address_build="";
                if ($receiver_address_district<>"" && $receiver_address_khoroo<>"")
                $receiver_address = $receiver_address_city_name." ".$receiver_address_district_name.", ".$receiver_address_khoroo."-р хороо".$receiver_address_build;

            }



            




            $proxy_name=proxy2($proxy,$proxy_type,"full_name");
            $proxy_contact=proxy2($proxy,$proxy_type,"tel");
            $proxy_address=proxy2($proxy,$proxy_type,"address");
    
       
           if ($package!="")
        {$package_array=explode("##",$package);
        if (count($package_array)>=3)  //PACKACGE ARRAY CHECK
        {
           $package1_name = $package_array[0];
        $package1_num = $package_array[1];
        $package1_value = intval($package_array[2]);
        $package2_name = $package_array[3];
        $package2_num = $package_array[4];
        $package2_value = intval($package_array[5]);
        $package3_name = $package_array[6];
        $package3_num = $package_array[7];
        $package3_value = intval($package_array[8]);
        $package4_name = $package_array[9];
        $package4_num = $package_array[10];
        $package4_value = intval($package_array[11]);
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
        
        // Generate barcode image
        barcode_generate($barcode);
        $barcode_temp_path = 'assets/img/barcode_temp.jpg';
    
        ini_set('memory_limit', '-1');
        $font = $font_path;
        $font_size = 15;
        
        // Create image - errors should be caught before header is set
        $image = @imagecreatefromjpeg($cp72Path);
        if (!$image) {
            // Can't change header now, output error as image comment or create error image
            $error_image = imagecreatetruecolor(800, 100);
            $bg_color = imagecolorallocate($error_image, 255, 255, 255);
            $text_color = imagecolorallocate($error_image, 255, 0, 0);
            imagefill($error_image, 0, 0, $bg_color);
            imagestring($error_image, 5, 10, 40, "Error: Cannot load CP72 template image", $text_color);
            imagepng($error_image);
            imagedestroy($error_image);
            exit;
        }
        
        $color = imagecolorallocate($image, 0, 0, 0);
        
        // Load barcode image (generated by barcode_generate function)
        if (!file_exists($barcode_temp_path)) {
            // Create placeholder barcode image
            $barcode_image_source = imagecreatetruecolor(334, 63);
            $bg = imagecolorallocate($barcode_image_source, 255, 255, 255);
            imagefill($barcode_image_source, 0, 0, $bg);
        } else {
            $barcode_image_source = @imagecreatefromjpeg($barcode_temp_path);
            if (!$barcode_image_source) {
                $barcode_image_source = imagecreatetruecolor(334, 63);
                $bg = imagecolorallocate($barcode_image_source, 255, 255, 255);
                imagefill($barcode_image_source, 0, 0, $bg);
            }
        }
        
        // Load logo image
        if (!file_exists($logo_path)) {
            // Create placeholder logo image
            $logo_image_source = imagecreatetruecolor(110, 110);
            $bg = imagecolorallocate($logo_image_source, 255, 255, 255);
            imagefill($logo_image_source, 0, 0, $bg);
        } else {
            $logo_image_source = @imagecreatefromjpeg($logo_path);
            if (!$logo_image_source) {
                $logo_image_source = imagecreatetruecolor(110, 110);
                $bg = imagecolorallocate($logo_image_source, 255, 255, 255);
                imagefill($logo_image_source, 0, 0, $bg);
            }
        }
        
        //imagettftext($image,$font_size,0,300,230,$color,$font,$barcode);
        imagettftext($image,$font_size,0,79,90,$color,$font,$sender_name);
        imagettftext($image,$font_size,0,255,195,$color,$font,$sender_contact);
        imagettftext($image,$font_size,0,79,120,$color,$font,substr($sender_address,0,18));
        imagettftext($image,$font_size,0,79,140,$color,$font,substr($sender_address,18,18));
        imagettftext($image,$font_size,0,79,160,$color,$font,substr($sender_address,36,18));
        
        if ($proxy==0)
        {
            imagettftext($image,$font_size,0,490,93,$color,$font,$receiver_name);
            imagettftext($image,$font_size,0,400,192,$color,$font,$receiver_contact);
            if ($receiver_address_district<>"" && $receiver_address_khoroo<>"")
                {
                    imagettftext($image,$font_size-5,0,450,110,$color,$font, $receiver_address_city_name." ".$receiver_address_district_name);
                    imagettftext($image,$font_size-5,0,450,130,$color,$font, $receiver_address_khoroo."-р хороо  ".$receiver_address_build);
                    //imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($receiver_address,72,36));
                }
                else 
                {
                    imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($receiver_address,0,36));
                    imagettftext($image,$font_size-5,0,450,130,$color,$font,substr($receiver_address,36,36));
                    imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($receiver_address,72,36));
                }
        }
        
        if ($proxy!=0)
        {
            imagettftext($image,$font_size,0,490,93,$color,$font,$proxy_name);
            imagettftext($image,$font_size,0,400,192,$color,$font,$proxy_contact);
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
            
            
            
            
            imagettftext($image,$font_size,0,430,280,$color,$font,number_format($package1_value, 2, '.', ','));
            imagettftext($image,$font_size,0,430,305,$color,$font,number_format($package2_value, 2, '.', ','));
            imagettftext($image,$font_size,0,430,330,$color,$font,number_format($package3_value, 2, '.', ','));
            imagettftext($image,$font_size,0,430,355,$color,$font,number_format($package4_value, 2, '.', ','));
            
            imagettftext($image,$font_size,0,380,375,$color,$font,number_format($price, 2, '.', ','));
        }
        
        
        imagettftext($image,$font_size,0,800,70,$color,$font,$weight);
        //imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price($weight)."$");
        imagettftext($image,$font_size,0,800,120,$color,$font,number_format(cfg_price($weight), 2, '.', ',')."$");
        imagettftext($image,$font_size,0,1100,1040,$color,$font,number_format($price, 2, '.', ',')."$");
        
        imagettftext($image,$font_size,0,280,480,$color,$font,str_replace('-','  ',substr($created_date,0,10)));
        imagettftext($image,$font_size+5,0,780,340,$color,$font,str_replace(':',' :  ',substr($created_date,10,6)));
        
            //GIFT SAMPLE DOCUMENT
        /*if ($inside=="gift")
        imagettftext($image,$font_size+15,0,1382,732,$color,$font, '*');	
        if ($inside=="sample")
        imagettftext($image,$font_size+15,0,1552,732,$color,$font, '*');	
        if ($inside=="document")
        imagettftext($image,$font_size+15,0,1823,732,$color,$font, '*');	*/
        
        
        //WAY
        /*if ($way=="air")
        imagettftext($image,$font_size+5,0,805,175,$color,$font, '*');	
        if ($way=="surface")
        imagettftext($image,$font_size+5,0,805,200,$color,$font, '*');	
        if ($way=="sal")
        imagettftext($image,$font_size+5,0,805,235,$color,$font, '*');	
        */
        //Delivery_time
         /*if ($deliver_time=="express")
         imagettftext($image,$font_size,0,790,265,$color,$font, '*');	
         if ($deliver_time=="advice")
         imagettftext($image,$font_size,0,840,265,$color,$font, '*');	 
         */
         //RETURN TYPE,DAY,WAY,ADRESS
         
        /*	
         if ($return_type=="return_1")
         imagettftext($image,$font_size+15,0,20,510,$color,$font, '*');	 
         if ($return_type=="return_2")
         imagettftext($image,$font_size+15,0,20,530,$color,$font, '*');	
         if ($return_type=="return_3")
         imagettftext($image,$font_size+15,0,20,550,$color,$font, '*');	
         if ($return_type=="return_4")
         imagettftext($image,$font_size+15,0,1165,1470,$color,$font, '*');	
         */
        /* if ($return_type=="return_2"&&$return_day!="")
              imagettftext($image,$font_size+15,0,340,1470,$color,$font, $return_day);	
            
        if ($return_way=="air"&&$return_type!="return_4")
         imagettftext($image,$font_size+15,0,760,1430,$color,$font, '*');	 
          if ($return_way=="surface"&&$return_type!="return_4")
         imagettftext($image,$font_size+15,0,760,1490,$color,$font, '*');	
         
        
         if ($return_type=="return_3" && $return_address!="")
         imagettftext($image,$font_size-25,0,440,1580,$color,$font, $return_address);	
            */
        if($insurance && $insurance_value > 0)
        {
            imagettftext($image,$font_size+15,0,115,400,$color,$font, '*');	//INSURANCE
            imagettftext($image,$font_size,0,180,400,$color,$font, number_format($insurance_value, 2, '.', ',')."$");	//insurance in digits
            //imagettftext($image,$font_size,0,440,400,$color,$font, number2words($insurance_value)." USD");
            //insurance in string
        }
        
        
        imagettftext($image,$font_size,0,510,510,$color,$font,"Track ".$third_party);
    
        imagecopymerge($image, $barcode_image_source, 550, 530, 0,0,334, 63,100);
        imagecopymerge($image, $logo_image_source, 785, 370, 0,0,110, 110,100);
    
        
        imagejpeg($image);
        imagedestroy($image);
        imagedestroy($barcode_image_source);
        imagedestroy($logo_image_source);
	
   }
  ?>
