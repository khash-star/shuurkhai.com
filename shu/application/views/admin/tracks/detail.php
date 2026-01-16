<? if (!$this->uri->segment(3)) redirect('agents/display'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Track:Detail</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$deliver=$row->deliver;
		$barcode=$row->barcode;
		$package=$row->package;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$Package_advance=$row->advance;
		$Package_advance_value=$row->advance_value;
		$way=$row->way;
		$inside=$row->inside;
		$deliver_time=$row->deliver_time;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		$track=$row->third_party;
		$status=$row->status;
		$timestamp=$row->timestamp;
		$extra=$row->extra;
		$weight=$row->weight;
   
   		//SENDER 
		if ($sender!="")
		{
		$query_sender = $this->db->query("SELECT * FROM customer WHERE customer_id='$sender' LIMIT 1");
		foreach ($query_sender->result() as $row_sender)
		{
			$sender_name=$row_sender->name;
			$sender_surname=$row_sender->surname;
			$sender_contact=$row_sender->tel;
			$sender_address=$row_sender->address;
			$sender_rd=$row_sender->rd;

		}
		} else $sender_name="";
		
		//RECIEVER
		if ($receiver!="")
		{
		$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id='$receiver' LIMIT 1");
		foreach ($query_reciever->result() as $row_reciever)
		{
			$reciever_name=$row_reciever->name;
			$reciever_surname=$row_reciever->surname;
			$reciever_address=$row_reciever->address;
			$reciever_rd=$row_reciever->rd;
			$reciever_contact=$row_reciever->tel;
		}
		} else {$reciever_name="";$reciever_contact="";}
		
		//DELIVER
		if ($deliver!="")
		{
		$sql = "SELECT * FROM customer WHERE customer_id='$deliver' LIMIT 1";
		$query_deliver = $this->db->query($sql);
		if ($query_deliver->num_rows()==0)
		{$deliver_name="";$deliver_contact="";}
		if ($query_deliver->num_rows()==1)
		foreach ($query_deliver->result() as $row_deliver)
		{
			$deliver_name=$row_deliver->name;
			$deliver_contact=$row_deliver->tel;
			$deliver_rd=$row_deliver->rd;
		}
		}else {$deliver_name="";$deliver_contact="";$deliver_rd="";}
   
   	$package_array=explode("##",$package);
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
	
   
   
    echo "<table class='table table-hover'>";
    echo "<tr><td>Илгээмжийн огноо</td><td>".$created_date."</td></tr>";
	echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
	echo "<tr><td>Нэр</td><td>".$reciever_name."</td></tr>" ;
	echo "<tr><td>Овог</td><td>".$reciever_surname."</td></tr>" ;
	echo "<tr><td>РД</td><td>".$reciever_rd."</td></tr>" ;
	echo "<tr><td>Утас</td><td>".$reciever_contact."</td></tr>" ;
	echo "<tr><td>Хаяг</td><td>".$reciever_address."</td></tr>" ;
	if ($deliver!=0)
	{
	echo "<tr><th colspan='2'><h4>Гардан авсан</h4></th></tr>";
	echo "<tr><td>Нэр</td><td>".$deliver_name."</td></tr>" ;
	echo "<tr><td>Утас</td><td>".$deliver_contact."</td></tr>" ;
	echo "<tr><td>РД:</td><td>".$deliver_rd."</td></tr>" ;
	}
	
    echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num) $package1_value$</td></tr>";
	if ($package2_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num) $package2_value$</td></tr>";
	if ($package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num) $package3_value$</td></tr>";
	if ($package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num) $package4_value$</td></tr>";
	/*if ($insurance)
	{
	echo "<tr><td>Даатгал</td><td>Даатгалтай</td></tr>" ;
	echo "<tr><td>Даатгалын хэмжээ</td><td>".$insurance_value."</td></tr>" ;		
	}
	else echo "<tr><td>Даатгал</td><td>Даатгалгүй</td></tr>" ;*/
	//if ($Package_advance)
	//{
	//echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлтэй</td></tr>" ;
	echo "<tr><td>Жин</td><td>".$weight."(".cfg_price($weight).")</td></tr>" ;	
	echo "<tr><td>Үлдэгдэлийн хэмжээ</td><td>".$Package_advance_value."$</td></tr>" ;		
	//}
	//else echo "<tr><td>Үлдэгдэл</td><td>Үлдэгдэлгүй</td></tr>" ;
	
	echo "<tr><td>Бусад track№</td><td>$track</td></tr>" ;

	/*echo "<tr><td>Явах чиглэл</td><td>$way</td></tr>" ;
	echo "<tr><td>Илгээмж дотор</td><td>$inside</td></tr>" ;
	echo "<tr><td>Хүргэгдэх үед</td><td>$deliver_time</td></tr>" ;
	switch($return_type)
	{
	case "return_1":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу яаралтай буцаах</td></tr>" ;break;
	case "return_2":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Явуулагч талруу $return_day өдрийн дараа буцаах</td></tr>" ;break;
	case "return_3":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Өөр хаягруу буцаах:$return_address;</td></tr>" ;break;
	case "return_4":echo "<tr><td>Хүргэгдээгүй тохиолдолд</td><td>Тэнд нь устгах</td></tr>" ;break;
	}
	echo "<tr><td>Буцах зам</td><td>$return_way</td></tr>" ;*/
	echo "<tr><td>Статус</td><td>".$status."(".$timestamp.")</td></tr>";
	if($status=="warehouse") echo "<tr><td>Тавиур</td><td>".$extra."-р тавиур</td></tr>";
	echo "</table>";
	
	/*echo form_open('agents/changing');
	echo form_hidden('order_id',$order_id);
	$options = array(
				  //''  => 'Шинэ төлөвийн сонго',
                  //'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  // 'warehouse'   => 'Агуулахад орсон',
                  //'custom' => 'Гааль',
				 // 'delete' => 'Barcode устгах',
                );


	echo form_dropdown('options', $options, '',array("class"=>"form-control"));
	echo "<div id='more'></div>";
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
	*/
   }
   else echo "Илгээмж олдсонгүй<br>";

?>

</div>
</div>