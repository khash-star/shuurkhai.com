<? if ($this->uri->segment(3)) $order_id=$this->uri->segment(3); else exit();

//ORDER STATUS CHANGE INTO new
$query_order = $this->db->query('SELECT status FROM orders WHERE order_id="'.$order_id.'"');
if ($query_order->num_rows()==1)
{
	$row = $query_order->row();
	if ($row->status=="filled")  
	$this->db->query('UPDATE orders SET status="new" WHERE order_id="'.$order_id.'"');
	//if ($row->status!="new" && $row->status!="filled")  
	//exit();
}

require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");

header('Content-Type: image/png');

$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
   		$sender=$row->sender;
		$receiver=$row->receiver;
		$proxy=$row->proxy_id;
		$proxy_type=$row->proxy_type;
		$barcode=$row->barcode;
		$package=$row->package;
		$weight=$row->weight;
		$price=$row->price;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$third_party=$row->third_party;
		$way=$row->way;
		$inside=$row->inside;
		$deliver_time=$row->deliver_time;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		$status=$row->status;
   
   		//SENDER 
		$sender_name=customer($sender,"full_name");
		$sender_address=customer($sender,"address");
		$sender_contact =customer($sender,"tel");
		//RECIEVER

		$receiver_name=customer($receiver,"full_name");
		$receiver_contact=customer($receiver,"tel");
		$receiver_address=customer($receiver,"address");


		$query_reciever = $this->db->query("SELECT customer.*,city.name AS city_name,district.name AS district_name FROM customer 
		LEFT JOIN city ON customer.address_city=city.id 
		LEFT JOIN district ON customer.address_district=district.id 
		WHERE customer_id='$receiver' LIMIT 1");
		foreach ($query_reciever->result() as $row_receiver)
		{
			$receiver_name=$row_receiver->name;
			$receiver_contact=$row_receiver->tel;
			$receiver_address=$row_receiver->address;
			$receiver_address_city=$row_receiver->address_city;
			$receiver_address_city_name = $row_receiver->city_name;
			$receiver_address_district=$row_receiver->address_district;
			$receiver_address_district_name=$row_receiver->district_name;
			$receiver_address_khoroo=$row_receiver->address_khoroo;
			$receiver_address_build=$row_receiver->address_build;
			if ($receiver_address_district<>"" && $receiver_address_khoroo<>"")
			$receiver_address = $receiver_address_city_name." ".$receiver_address_district_name.", ".$receiver_address_khoroo."-р хороо".$receiver_address_build;

		}


		//PROXY
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
	barcode_generate($barcode);


	ini_set('memory_limit', '-1');
	$font='assets/fonts/Arial.ttf';
	$font_size=15;
    $cp72Path ='assets/images/cp72.jpg';
    $image = imagecreatefromjpeg($cp72Path);
    $color = imagecolorallocate($image, 0, 0, 0);
	$barcode_image_source = imagecreatefromjpeg('assets/barcode_temp.jpg');
	$logo_image_source = imagecreatefromjpeg('assets/images/logo.jpg');
	
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
	
	
	
	
	imagettftext($image,$font_size,0,430,280,$color,$font,$package1_value);
	imagettftext($image,$font_size,0,430,305,$color,$font,$package2_value);
	imagettftext($image,$font_size,0,430,330,$color,$font,$package3_value);
	imagettftext($image,$font_size,0,430,355,$color,$font,$package4_value);
	
	imagettftext($image,$font_size,0,380,375,$color,$font,$price);
	}
	
	
	imagettftext($image,$font_size,0,800,70,$color,$font,$weight);
	//imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price($weight)."$");
	imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price($weight)."$");
	imagettftext($image,$font_size,0,1100,1040,$color,$font,$price."$");
	
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
	if($insurance)
	{
	imagettftext($image,$font_size+15,0,115,400,$color,$font, '*');	//INSURANCE
	imagettftext($image,$font_size,0,180,400,$color,$font, $insurance_value."$");	//insurance in digits
	//imagettftext($image,$font_size,0,440,400,$color,$font, number2words($insurance_value)." USD");
	//insurance in string
	}
	
	
	imagettftext($image,$font_size,0,510,510,$color,$font,"Track ".$third_party);

	imagecopymerge($image, $barcode_image_source, 550, 530, 0,0,334, 63,100);
	imagecopymerge($image, $logo_image_source, 785, 370, 0,0,110, 110,100);
	

 	imagejpeg($image);
	
   }
  ?>