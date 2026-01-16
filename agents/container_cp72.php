<? 
if (isset($_GET["id"])) $id=$_GET["id"]; else $id =0;
require_once('config.php');
require_once('views/helper.php');

require_once('assets/vendor/libs/BCG/BCGFontFile.php');
require_once('assets/vendor/libs/BCG/BCGDrawing.php');
require_once('assets/vendor/libs/BCG/BCGcode128.barcode.php');
// require_once("barcode_writer.php");




header('Content-Type: image/png');
$sql = "SELECT * FROM container_item WHERE id=".$id;
$result = mysqli_query($conn,$sql);


if (mysqli_num_rows($result)==1)
{
    $data = mysqli_fetch_array($result);
    
   		$created_date=$data["created_date"];
		$id=$data["id"];
  	 	$sender=$data["sender"];
   		$receiver=$data["receiver"];
        $proxy=$data["proxy_id"];
   
           
		$barcode=$data["barcode"];
		$package=$data["package"];
		$weight=$data["weight"];
		$price=$data["price"];
		$status=$data["status"];
        $third_party = $data["track"];
        
        $payment= intval($data["payment"]);
        $pay_in_mongolia= intval($data["pay_in_mongolia"]);
   
   		//SENDER 

           $sender_first_name=customer($sender,"name");
			$sender_name=customer($sender,"full_name");
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



            



            // $proxy_name=proxy2($proxy,$proxy_type,"full_name");
            // $proxy_contact=proxy2($proxy,$proxy_type,"tel");
            // $proxy_address=proxy2($proxy,$proxy_type,"address");
    
       
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
        barcode_generate($barcode);
    
    
        ini_set('memory_limit', '-1');
        $font='assets/fonts/Arial.ttf';
        $font_size=15;
        $cp72Path ='assets/img/cp72_container_ex.jpg';
        $image = imagecreatefromjpeg($cp72Path);
        $color = imagecolorallocate($image, 0, 0, 0);
        $barcode_image_source = imagecreatefromjpeg('assets/img/barcode_temp.jpg');
        $logo_image_source = imagecreatefromjpeg('assets/img/logo.jpg');

        imagettftext($image,$font_size,0,79,90,$color,$font,$sender_name);
        imagettftext($image,$font_size,0,255,195,$color,$font,$sender_contact);
        imagettftext($image,$font_size,0,79,120,$color,$font,substr($sender_address,0,24));
        imagettftext($image,$font_size,0,79,140,$color,$font,substr($sender_address,24,24));
        imagettftext($image,$font_size,0,79,160,$color,$font,substr($sender_address,48,24));
        
        //if ($proxy==0)
        //{
        imagettftext($image,$font_size,0,490,93,$color,$font,$receiver_name);
        imagettftext($image,$font_size,0,400,192,$color,$font,$receiver_contact);
        imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($receiver_address,0,24));
        imagettftext($image,$font_size-5,0,450,130,$color,$font,substr($receiver_address,24,24));
        imagettftext($image,$font_size-5,0,450,160,$color,$font,substr($receiver_address,48,24));
        //}
        
        /*if ($proxy!=0)
        {
        imagettftext($image,$font_size,0,490,93,$color,$font,$proxy_name);
        imagettftext($image,$font_size,0,400,192,$color,$font,$proxy_contact);
        imagettftext($image,$font_size,0,500,192,$color,$font,"/99");
        imagettftext($image,$font_size-5,0,450,110,$color,$font,substr($proxy_address,0,36));
        imagettftext($image,$font_size-5,0,450,130,$color,$font,substr($proxy_address,36,36));
        imagettftext($image,$font_size-5,0,450,160,$color,$font,substr($proxy_address,72,36));
        }
        */

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
            
        imagettftext($image,$font_size,0,430,280,$color,$font,$package1_value);
        imagettftext($image,$font_size,0,430,305,$color,$font,$package2_value);
        imagettftext($image,$font_size,0,430,330,$color,$font,$package3_value);
        imagettftext($image,$font_size,0,430,355,$color,$font,$package4_value);
        
        imagettftext($image,$font_size,0,380,375,$color,$font,$price);
        }
        
        
        imagettftext($image,$font_size,0,800,70,$color,$font,$weight);
        //imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price2($weight)."$");
        imagettftext($image,$font_size,0,800,120,$color,$font,$pay_in_mongolia."$");
        imagettftext($image,$font_size,0,1100,1040,$color,$font,$price."$");
        
        imagettftext($image,$font_size,0,280,480,$color,$font,str_replace('-','  ',substr($created_date,0,10)));
        imagettftext($image,$font_size+5,0,780,340,$color,$font,str_replace(':',' :  ',substr($created_date,10,6)));
        
        imagecopymerge($image, $barcode_image_source, 550, 530, 0,0,334, 64,100);
        



        imagettftext($image,$font_size-3,0,295,685,$color,$font,$barcode);
        imagettftext($image,$font_size-3,0,758,685,$color,$font,$barcode);
        if ($package!="")
        {
        imagettftext($image,$font_size-3,0,180,710,$color,$font,substr($package1_name,0,20)." / ".$package1_num."pcs - ".$package1_value."$");
        if ($package2_name!="")	imagettftext($image,$font_size-3,0,80,740,$color,$font,substr($package2_name,0,100)." / ".$package2_num."pcs - ".$package2_value."$");
        if ($package3_name!="")imagettftext($image,$font_size-3,0,80,770,$color,$font,substr($package3_name,0,100)." / ".$package3_num."pcs - ".$package3_value."$");
        if ($package4_name!="")imagettftext($image,$font_size-3,0,80,805,$color,$font,substr($package4_name,0,100)." / ".$package4_num."pcs - ".$package4_value."$");
        imagettftext($image,$font_size-3,0,640,710,$color,$font,substr($package1_name,0,20)." / ".$package1_num."pcs - ".$package1_value."$");
        if ($package2_name!="") imagettftext($image,$font_size-3,0,540,740,$color,$font,substr($package2_name,0,100)." / ".$package2_num."pcs - ".$package2_value."$");
        if ($package3_name!="") imagettftext($image,$font_size-3,0,540,770,$color,$font,substr($package3_name,0,100)." / ".$package3_num."pcs - ".$package3_value."$");
        if ($package4_name!="")imagettftext($image,$font_size-3,0,540,805,$color,$font,substr($package4_name,0,100)." / ".$package4_num."pcs - ".$package4_value."$");
        }

        imagettftext($image,$font_size,0,120,838,$color,$font,$weight."kg");
        imagettftext($image,$font_size,0,580,838,$color,$font,$weight."kg");
        imagettftext($image,$font_size,0,300,838,$color,$font,$payment."$");
        imagettftext($image,$font_size,0,760,838,$color,$font,$payment."$");
        imagettftext($image,$font_size,0,300,870,$color,$font,$sender_first_name);
        imagettftext($image,$font_size,0,760,870,$color,$font,$sender_first_name);
        imagettftext($image,$font_size,0,150,870,$color,$font,"Shuurkhai Inc");
        imagettftext($image,$font_size,0,610,870,$color,$font,"Shuurkhai Inc");

        imagettftext($image,$font_size-3,0,20,870,$color,$font,substr($created_date,0,10));
        imagettftext($image,$font_size-3,0,490,870,$color,$font,substr($created_date,0,10));

        imagejpeg($image);
        
	
   }
  ?>