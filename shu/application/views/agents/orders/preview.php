<? if ($this->uri->segment(3)) $order_id=$this->uri->segment(3); else exit();
//ORDER STATUS CHANGE INTO new
$query_order = $this->db->query('SELECT status FROM orders WHERE order_id="'.$order_id.'"');
if ($query_order->num_rows()==1)
{
	$row = $query_order->row();
	if ($row->status=="filled")  
	$this->db->query('UPDATE orders SET status="new" WHERE order_id="'.$order_id.'"');
	if ($row->status!="new" || $row->status!="filled") 
	 $this->db->query('UPDATE orders SET status="new",print=1 WHERE order_id="'.$order_id.'"');
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
		//$proxy=$row->proxy_id;
		$barcode=$row->barcode;
		$package=$row->package;
		$weight=$row->weight;
		$price=$row->price;
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
		$advance_value  = $row->advance_value;
   
   		//SENDER 
   		$sender_first_name=customer($sender,"name");
		$sender_name=customer($sender,"full_name");
		$sender_address=customer($sender,"address");
		$sender_contact =customer($sender,"tel");
		//RECIEVER

		$receiver_name=customer($receiver,"full_name");
		$receiver_contact=customer($receiver,"tel");
		$receiver_address=customer($receiver,"address");

		//PROXY
		//$proxy_name=proxy($proxy,"full_name");
		//$proxy_contact=proxy($proxy,"tel");
		//$proxy_address=proxy($proxy,"address");

   
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
    $cp72Path ='assets/images/cp72ex.jpg';
    $image = imagecreatefromjpeg($cp72Path);
    $color = imagecolorallocate($image, 0, 0, 0);
	$barcode_image_source = imagecreatefromjpeg('barcode_temp.jpg');
	//$logo_image_source = imagecreatefromjpeg('assets/images/logo.jpg');
	
	//imagettftext($image,$font_size,0,300,230,$color,$font,$barcode);
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
	imagettftext($image,$font_size,0,800,120,$color,$font,cfg_price_selfdrop($weight)."$");
	//imagettftext($image,$font_size,0,800,120,$color,$font,$advance_value."$");
	
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
	imagettftext($image,$font_size,0,300,838,$color,$font,cfg_price_selfdrop($weight)."$");
	imagettftext($image,$font_size,0,760,838,$color,$font,cfg_price_selfdrop($weight)."$");
// 	imagettftext($image,$font_size,0,300,838,$color,$font,$advance_value."$");
// 	imagettftext($image,$font_size,0,760,838,$color,$font,$advance_value."$");
	
	imagettftext($image,$font_size,0,300,870,$color,$font,$sender_first_name);
	imagettftext($image,$font_size,0,760,870,$color,$font,$sender_first_name);
	imagettftext($image,$font_size,0,150,870,$color,$font,"Shuurkhai Inc");
	imagettftext($image,$font_size,0,610,870,$color,$font,"Shuurkhai Inc");

	imagettftext($image,$font_size-3,0,20,870,$color,$font,substr($created_date,0,10));
	imagettftext($image,$font_size-3,0,490,870,$color,$font,substr($created_date,0,10));

 	imagejpeg($image);
	
   }
  ?>