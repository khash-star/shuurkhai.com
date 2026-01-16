<? if (!$this->uri->segment(3)) redirect('orders/display'); else $order_id=$this->uri->segment(3);
require_once('assets/class/BCGFontFile.php');
require_once('assets/class/BCGDrawing.php');
require_once('assets/class/BCGcode128.barcode.php');
require_once("barcode_writer.php");




header('Content-Type: image/png');

$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

//if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$package=$row->package;
		$weight=$row->weight;
		$price=$row->price;
		//$description=$row->description;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		//$third_party=$row->third_party;
		$way=$row->way;
		$inside=$row->inside;
		$deliver_time=$row->deliver_time;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		$status=$row->status;
   
   		//SENDER 

			$sender_name=customer($sender,"name");
			$sender_contact=customer($sender,"tel");
			$sender_address=customer($sender,"address");

		
		
		//RECIEVER
		
			$receiver_name=customer($receiver,"name");
			$receiver_contact=customer($receiver,"tel");
			$receiver_address=customer($receiver,"address");

		$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id='$receiver' LIMIT 1");
		foreach ($query_reciever->result() as $row_receiver)
		{
			$receiver_name=$row_receiver->name;
			$receiver_contact=$row_receiver->tel;
			$receiver_address=$row_receiver->address;
		}
   
   	$package_array=explode("##",$package);
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

	barcode_generate($barcode);


	ini_set('memory_limit', '-1');
	$font='assets/fonts/Arial.ttf';
	$font_size=45;
    $cp72Path ='assets/images/cp72.jpg';
    $image = imagecreatefromjpeg($cp72Path);
    $color = imagecolorallocate($image, 0, 0, 0);
	$barcode_image_source = imagecreatefromjpeg('assets/barcode_temp.jpg');
	$logo_image_source = imagecreatefromjpeg('assets/images/logo.jpg');

	//imagettftext($image,$font_size,0,300,230,$color,$font,$barcode);
	imagettftext($image,$font_size,0,240,270,$color,$font,$sender_name);
	imagettftext($image,$font_size,0,700,560,$color,$font,$sender_contact);
	imagettftext($image,$font_size-5,0,240,340,$color,$font,substr($sender_address,0,36));
	imagettftext($image,$font_size-5,0,240,400,$color,$font,substr($sender_address,36,36));
	imagettftext($image,$font_size-5,0,240,460,$color,$font,substr($sender_address,72,36));
	imagettftext($image,$font_size,0,1240,270,$color,$font,$receiver_name);
	imagettftext($image,$font_size,0,1120,560,$color,$font,$receiver_contact);
	imagettftext($image,$font_size-5,0,1240,340,$color,$font,substr($receiver_address,0,36));
	imagettftext($image,$font_size-5,0,1240,400,$color,$font,substr($receiver_address,36,36));
	imagettftext($image,$font_size-5,0,1240,460,$color,$font,substr($receiver_address,72,36));
	
	imagettftext($image,$font_size-15,0,80,780,$color,$font,$package1_name);
	imagettftext($image,$font_size-15,0,80,840,$color,$font,$package2_name);
	imagettftext($image,$font_size-15,0,80,900,$color,$font,$package3_name);
	imagettftext($image,$font_size-15,0,80,960,$color,$font,$package4_name);
	
	imagettftext($image,$font_size-15,0,620,780,$color,$font,$package1_num);
	imagettftext($image,$font_size-15,0,620,840,$color,$font,$package2_num);
	imagettftext($image,$font_size-15,0,620,900,$color,$font,$package3_num);
	imagettftext($image,$font_size-15,0,620,960,$color,$font,$package4_num);
	
	
	/*imagettftext($image,$font_size-15,0,720,780,$color,$font,$package1_produced);
	imagettftext($image,$font_size-15,0,720,840,$color,$font,$package1_produced);
	imagettftext($image,$font_size-15,0,720,900,$color,$font,$package1_produced);
	imagettftext($image,$font_size-15,0,720,960,$color,$font,$package1_produced);
	
	imagettftext($image,$font_size-15,0,940,780,$color,$font,$package1_weight);
	imagettftext($image,$font_size-15,0,940,840,$color,$font,$package2_weight);
	imagettftext($image,$font_size-15,0,940,900,$color,$font,$package3_weight);
	imagettftext($image,$font_size-15,0,940,960,$color,$font,$package4_weight);*/
	
	imagettftext($image,$font_size-15,0,1190,780,$color,$font,$package1_value);
	imagettftext($image,$font_size-15,0,1190,840,$color,$font,$package2_value);
	imagettftext($image,$font_size-15,0,1190,900,$color,$font,$package3_value);
	imagettftext($image,$font_size-15,0,1190,960,$color,$font,$package4_value);
	
	
	
	imagettftext($image,$font_size,0,2250,220,$color,$font,$weight);
	//imagettftext($image,$font_size,0,2200,350,$color,$font,cfg_price($weight)."$");
	imagettftext($image,$font_size,0,2200,350,$color,$font,cfg_price2($weight)."$");
	imagettftext($image,$font_size-15,0,1100,940,$color,$font,$price."$");
	
	imagettftext($image,$font_size,0,822,1320,$color,$font,str_replace('-','  ',substr($created_date,0,10)));
	imagettftext($image,$font_size+5,0,2150,950,$color,$font,str_replace(':',' :  ',substr($created_date,10,6)));
	
		//GIFT SAMPLE DOCUMENT
	if ($inside=="gift")
	imagettftext($image,$font_size+15,0,1382,732,$color,$font, '*');	
	if ($inside=="sample")
	imagettftext($image,$font_size+15,0,1552,732,$color,$font, '*');	
	if ($inside=="document")
	imagettftext($image,$font_size+15,0,1823,732,$color,$font, '*');	
	
	
	//WAY
	if ($way=="air")
	imagettftext($image,$font_size+15,0,2196,502,$color,$font, '*');	
	if ($way=="surface")
	imagettftext($image,$font_size+15,0,2196,590,$color,$font, '*');	
	if ($way=="sal")
	imagettftext($image,$font_size+15,0,2196,668,$color,$font, '*');	
	
	//Delivery_time
	 if ($deliver_time=="express")
	 imagettftext($image,$font_size+15,0,2150,750,$color,$font, '*');	
	 if ($deliver_time=="advice")
	 imagettftext($image,$font_size+15,0,2290,750,$color,$font, '*');	 
	 
	 //RETURN TYPE,DAY,WAY,ADRESS
	 
		
	 if ($return_type=="return_1")
	 imagettftext($image,$font_size+15,0,85,1430,$color,$font, '*');	 
	 if ($return_type=="return_2")
	 imagettftext($image,$font_size+15,0,85,1490,$color,$font, '*');	
	 if ($return_type=="return_3")
	 imagettftext($image,$font_size+15,0,85,1560,$color,$font, '*');	
	 if ($return_type=="return_4")
	 imagettftext($image,$font_size+15,0,1165,1470,$color,$font, '*');	
	 
	 if ($return_type=="return_2"&&$return_day!="")
	 	 imagettftext($image,$font_size+15,0,340,1470,$color,$font, $return_day);	
		
	 if ($return_way=="air"&&$return_type!="return_4")
	 imagettftext($image,$font_size+15,0,760,1430,$color,$font, '*');	 
      if ($return_way=="surface"&&$return_type!="return_4")
	 imagettftext($image,$font_size+15,0,760,1490,$color,$font, '*');	
	 
	 
	 if ($return_type=="return_3" && $return_address!="")
	 imagettftext($image,$font_size-25,0,440,1580,$color,$font, $return_address);	
		
	if($insurance)
	{
	imagettftext($image,$font_size+15,0,330,1155,$color,$font, '*');	//INSURANCE
	imagettftext($image,$font_size,0,1200,1155,$color,$font, $insurance_value."$");	//insurance in digits
	imagettftext($image,$font_size-10,0,520,1155,$color,$font, number2words($insurance_value)." USD");
	//insurance in string
	}
	
	
	imagecopymerge($image, $barcode_image_source, 1430, 1450, 0,0,1002, 195,100);
	imagecopymerge($image, $logo_image_source, 2130, 1010, 0,0,1002, 300,300);
	

 	imagejpeg($image);
    /*imagejpeg($image,"cp72_new.jpg");
	echo "<img src='".base_url()."cp72_new.jpg' class='cp72_bg'><br><br>";


	
	
	
	
	
	
	echo "</div>";
	echo anchor('','хэвлэх',array('onclick'=>"window.print();"))."<br>";
	echo anchor('orders/detail/'.$order_id,'Илгээмжруу буцах')."<br>";
   	echo anchor('orders/display/','Бүх захиалгууд')."<br>";*/
	
   }
  ?>