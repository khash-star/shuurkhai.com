<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж өөрчилөх</div>
  <div class="panel-body">
<? 
		$options=$_POST["options"];

		switch ($options)
	    {
		case "delivered": $new_status = "delivered";break;
		case "onair":$new_status = "onair";break;
		case "warehouse":$new_status = "warehouse";$extra=$_POST["bench"];break;
		case "custom":$new_status = "custom";break;
		//case "delete":$new_status = "new";break;
		}


		if ( $new_status=="delivered")
			{
			$deliver_surname = $_POST["deliver_surname"];
			$deliver_name = $_POST["deliver_name"];
			$deliver_rd = $_POST["deliver_rd"];
			$deliver_email = $_POST["deliver_email"];
			$deliver_contact = $_POST["deliver_contact"];
			$deliver_address = $_POST["deliver_address"];
			$query_deliver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$deliver_contact.'"');
			if ($query_deliver->num_rows()==0)
				{
					$data = array(
							   'name'=>$deliver_name,
							   'surname'=>$deliver_surname,
							   'rd'=>$deliver_rd,
							   'tel'=>$deliver_contact ,
							   'email'=>$deliver_email,
							   'address'=>$deliver_address,
							   //'country'=>'MONGOLIA',
							   'status'=> 'regular'
								 );
				if ($this->db->insert('customer', $data)) ;
				$deliver_id=$this->db->insert_id()  ;
				}
				else {foreach ($query_deliver->result() as $row){$deliver_id=$row->customer_id;}}	
			}
		
	if(isset($_POST['orders'])) {$orders=$_POST['orders'];$N = count($orders);}
	if(isset($_POST['order_id'])) {$order_id=$_POST['order_id'];$N = 1;}
	 else {$N = count($orders); $order_id="";}

	if ($N!=0 || $order_id!="")
	{
	$count=1;
		
   	echo "<table class='table table-hover'>";
    echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлбөр</th>";
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Шинэ төлөв</th>"; 
	   echo "<th>Алдаа</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
    for($i=0; $i < $N; $i++)
    {
if ($order_id=="") $order_id=$orders[$i];
$query = $this->db->query("SELECT orders.*,orders.status AS order_status,customer.*,customer.tel AS contact FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id WHERE order_id=".$order_id);

foreach ($query->result() as $row)
		{
		$order_id=$row->order_id;
		$created_date=$row->created_date;
		//$onair_date=$row->onair_date;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$Package_advance_value=$row->advance_value;
		$barcode=$row->barcode;
		//$package=$row->package;
		//$insurance=$row->insurance;
		//$insurance_value=$row->insurance_value;
		//$description=$row->description;
		$status=$row->order_status;


//SENDER 
		$query_sender = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$sender\" LIMIT 1");
		foreach ($query_sender->result() as $row_sender)
		{
			$sender_name=$row_sender->name;

		}
		
		//RECIEVER
		$query_receiver = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
		foreach ($query_receiver->result() as $row_receiever)
		{
			$receiver_name=$row_receiever->name;
			$receiver_contact=$row_receiever->tel;
		}
		
	   $days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
		}
		$error="";
		if($new_status=="delivered") 
		{
			if ($deliver_id!="" && $status=="warehouse")
			$data = array(
               'status' => $new_status,
			   'deliver' => $deliver_id
            		  );	
					  else $error = "Агуулахад байхгүй эсвэл ирж авагч тодорхойгүй";
		}
		
		if($new_status=="warehouse")
		{
			if ($status=="onair" )
			$data = array(
               'status' => $new_status,
			   'extra' => $extra,
			   'warehouse_date' => date("c")
            		  );	
		else $error = "Онгоцоор ирж буй төлөвт биш байна";
		}
		
		if($new_status=="onair")
		{
		//if ($status=="new")
		$data = array(
               'status' => $new_status,
			 //  'extra' => $extra,
			   'onair_date' => date("c")
            		  );	
		//else $error = "Нисэхэд бэлэн төлөвт биш байна";
		}
		
		
		if($new_status=="custom")
		{if  ($status=="onair") 
			$data = array(
               'status' => $new_status,
			 //  'extra' => $extra,
			  //'onair_date' => date("c")
            		  );	
			else $error = "Онгоцоор ирж буй төлөвт биш байна";
		}
		

		if ($error=="")
		{
		$this->db->where('order_id', $order_id);
		if ($this->db->update('orders', $data)) 
			{ 
			  //MSG SENDING
				$data["order_id"]=$order_id;
				//$this->load->view("sms/sendsms",$data);
			  //MAIL SENDING
			    $data['order_id']=$order_id;
				//$this->load->view('mail/mail_send',$data);
			}
		}
		$tr=0;
		if ($error!=""&&!$tr)
		{echo "<tr class=\"red\">"; $tr=1;}
		
		if (!$tr) echo "<tr>";else $tr=0;
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date."</td>"; 
       echo "<td>".$sender_name."</td>"; 
	   echo "<td>".$receiver_name."</td>";
	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$Package_advance_value."</td>"; 
	   echo "<td>".$status."</td>";
	   if ($new_status!="warehouse")
	   echo "<td>".$new_status."</td>";
	   else echo "<td>".$new_status." ".$extra."-р тавиур</td>";
	   echo "<td>".$error."</td>";
	   echo "<td>".anchor('orders/detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	    echo "</tr>";		
		$order_id="";      
	}
	echo "</table>";
	}
	else echo "Илгээмж тэмдэглэгдээгүй байна";
?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('orders', 'Илгээмжүүд')?></li>
<li><?=anchor('orders/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->