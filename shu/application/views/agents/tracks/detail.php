<? if (!$this->uri->segment(3)) redirect('agents/tracks'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Tracks</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
  	 	//$sender=$row->sender;
   		$receiver=$row->receiver;
		$deliver=$row->deliver;
		$barcode=$row->barcode;
		$package=$row->package;
		//$description=$row->description;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$Package_advance=$row->advance;
		$Package_advance_value=$row->advance_value;
		$third_party=$row->third_party;
		$way=$row->way;
		$inside=$row->inside;
		$deliver_time=$row->deliver_time;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		$status=$row->status;
		$timestamp=$row->timestamp;
		$extra=$row->extra;
		$proxy= $row->proxy_id;
   
		//RECIEVER
		if ($receiver!="")
		{
			$receiver_name=customer($receiver,"name");
			$receiver_surname=customer($receiver,"surname");
			$receiver_address=customer($receiver,"address");
			$receiver_rd=customer($receiver,"rd");
			$receiver_contact=customer($receiver,"tel");
		} 
		
		//DELIVER
		if ($deliver!="")
		{
		$query_deliver = $this->db->query("SELECT * FROM customer WHERE customer_id='$deliver' LIMIT 1");
		foreach ($query_deliver->result() as $row_deliver)
		{
			$deliver_name=$row_deliver->name;
			$deliver_contact=$row_deliver->tel;
		}
		}else {$deliver_name="";$deliver_contact="";}
   	if ($package!="")
	{
		
   	$package_array=explode("##",$package);

		$package1_name = @$package_array[0];
		$package1_num = @$package_array[1];
		$package1_value = @$package_array[2];
		$package2_name = @$package_array[3];
		$package2_num = @$package_array[4];
		$package2_value = @$package_array[5];
		$package3_name = @$package_array[6];
		$package3_num = @$package_array[7];
		$package3_value = @$package_array[8];
		$package4_name = @$package_array[9];
		$package4_num = @$package_array[10];
		$package4_value = @$package_array[11];

	}
   
   
    echo "<table class='table table-hover'>";
    echo "<tr><td>Илгээмжийн огноо</td><td>".$created_date."</td></tr>";
	if ($receiver!="")
	{
    echo "<tr><td>Хүлээн авагчийн нэр</td><td>".$receiver_name."</td></tr>" ;
	echo "<tr><td>Хүлээн авагчийн овог</td><td>".$receiver_surname."</td></tr>" ;
	echo "<tr><td>Хүлээн авагчийн РД</td><td>".$receiver_rd."</td></tr>" ;
	echo "<tr><td>Хүлээн авагчын утас</td><td>".$receiver_contact."</td></tr>" ;
	echo "<tr><td>Хүлээн авагчийн хаяг</td><td>".$receiver_address."</td></tr>" ;
	}
	
	


   if ($deliver)
   {
	echo "<tr><td>Ирж авсан</td><td>".$deliver_name."</td></tr>" ;
	echo "<tr><td>Ирж авагчын утас</td><td>".$deliver_contact."</td></tr>" ;
   }
    echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
	echo "<tr><td>Илгээмж</td><td>".@$package1_name.",".@$package2_name.",".@$package3_name.",".@$package4_name."</td></tr>" ;
	/*if ($insurance)
	{
	echo "<tr><td>Даатгал</td><td>Даатгалтай</td></tr>" ;
	echo "<tr><td>Даатгалын хэмжээ</td><td>".$insurance_value."</td></tr>" ;		
	}
	else echo "<tr><td>Даатгал</td><td>Даатгалгүй</td></tr>" ;*/
	if ($Package_advance)
	{
	echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлтэй</td></tr>" ;
	echo "<tr><td>Үлдэгдэлийн хэмжээ</td><td>".$Package_advance_value."</td></tr>" ;		
	}
	else echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлгүй</td></tr>" ;
	if ($third_party)
	{
	echo "<tr><td>Бусад track№</td><td>$third_party</td></tr>" ;
	}
	echo "</table>";
	/*echo "<tr><td>Явах чиглэл</td><td>$way</td></tr>" ;
	echo "<tr><td>Илгээмж дотор</td><td>$inside</td></tr>" ;
	echo "<tr><td>Хүргэгдэх үед</td><td>$deliver_time</td></tr>" ;
	switch($return_type)
	{
	case "return_1":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу яаралтай буцаахe</td></tr>" ;break;
	case "return_2":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу $return_day өдрийн дараа буцаах</td></tr>" ;break;
	case "return_3":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Өөр хаягруу буцаах:$return_address;</td></tr>" ;break;
	case "return_4":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Тэнд нь устгах</td></tr>" ;break;
	}
	echo "<tr><td>Буцах зам</td><td>$return_way</td></tr>" ;
	echo "<tr><td>Тайлбар</td><td>".$package."</td></tr>";*/
	/*if ($package1_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num)</td></tr>";
	if ($package2_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num)</td></tr>";
	if ($package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num)</td></tr>";
	if ($package4_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num)</td></tr>";
	
	echo "<tr><td>Статус</td><td>".$status."(".$timestamp.")</td></tr>";
	if($status=="warehouse") echo "<tr><td>Тавиур</td><td>".$extra."-р тавиур</td></tr>";
	echo "</table>";
	
	echo form_open('agents/tracks_changing');
	echo form_hidden('order_id',$order_id);
	$options = array(
				 //''  => 'Шинэ төлөвийн сонго',
                  //'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор ирж байгаа',
                 // 'warehouse'   => 'Агуулахад орсон',
                 // 'custom' => 'Гааль',
				 // 'delete' => 'Barcode устгах',
                );


	echo form_dropdown('options', $options, '');
	echo "<div id='more'></div>";
	echo form_submit("submit","өөрчил");
	echo form_close();*/
	
   }
   else echo "Online илгээмж олдсонгүй<br>";

?>
</div> <!--side_menu-->
</div> <!--right_side-->
