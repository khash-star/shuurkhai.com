<div class="panel panel-primary">
  <div class="panel-heading">Barcode:Eliminating</div>
  <div class="panel-body">
<? 
$options=$_POST["options"];
	   echo "<table class='table table-hover'>";
	   echo "<tr>";
	   echo "<th>Barcode оруулсан</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Захиалгын огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	$barcode_id=$_POST['barcode_id'];
  	$N = count($barcode_id);
    for($i=0; $i < $N; $i++)
    {
 	$query = $this->db->query("SELECT barcode.*,barcode.timestamp AS tsp,orders.* FROM barcode LEFT JOIN orders ON barcode.barcode=orders.barcode WHERE barcode.barcode='".$barcode_id[$i]."' LIMIT 1");
		foreach ($query->result() as $row)
		{
		$timestamp=$row->tsp;
		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$package=$row->package;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$status=$row->status;
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

	
	   echo "<tr>";
	   echo "<td>".$timestamp."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$created_date."</td>"; 
       echo "<td>".$sender_name."</td>"; 
	   echo "<td>".$receiver_name."</td>"; 
	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$status."</td>"; 
	   echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	   
	   switch ($options)
	    {
		case "delivered": $new_status = "delivered";break;
		case "onair":$new_status = "onair";break;
		case "warehouse":$new_status = "warehouse";$extra=$_POST["bench"];break;
		case "custom":$new_status = "custom";$extra="";break;
		case "delete":$new_status = "delete";$extra="";break;
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
							   'status'=> 'regular'
								 );
				if ($this->db->insert('customer', $data)) ;
				$deliver_id=$this->db->insert_id()  ;
				}
			else {foreach ($query_deliver->result() as $row){$deliver_id=$row->customer_id;}}	
			}
			
		if ($new_status!="delivered")
		$data = array(
               'status' => $new_status,
			   'extra' => $extra
            		  );
		if($new_status=="delivered" && $deliver_id!="") 
		$data = array(
               'status' => $new_status,
			   'deliver' => $deliver_id
            		  );	
		if($new_status=="custom") 
		$data = array(
               'status' => $new_status,
			   'delivered_date'=>date("Y-m-d H:i:s")
            		  );	
					  
		if($options=="delivered")
	   $this->db->query("UPDATE orders SET status='$new_status',deliver='$deliver_id' WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
	   
	   if($options!="delete"&&$options!="delivered")
	   $this->db->query("UPDATE orders SET status='$new_status',extra='$extra' WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
	   if ($new_status!="delete")
		{
			//MSG SENDING
			$data["order_id"]=$order_id;
			//$this->load->view("sms/sendsms",$data);
			
			//MAIL SENDING
		$data['order_id']=$order_id;
		//$this->load->view('mail/mail_send',$data);
		}
	   $this->db->query("DELETE FROM barcode WHERE barcode='".$barcode_id[$i]."' LIMIT 1");
		}
    }
	echo "</table>";
	
	
	
?>

</div>
</div>