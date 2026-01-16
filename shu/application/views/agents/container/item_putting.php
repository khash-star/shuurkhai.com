<? 
 $container_id=$_POST["container_id"];

//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
if ($query->num_rows()==1)
	{
	$row = $query->row();
	$name= 	$row ->name;
	$created= 	$row ->created;
	$departed= 	$row ->departed;
	$expected= 	$row ->expected;
	$description= 	$row ->description;
	$status= 	$row ->status;
	echo "<b>".$name."</b><br>";
	echo "Үүсгэсэн огноо:".$created."<br>";
	echo "Төлөв:".$status."<br>";
	echo "Америкаас гарсан огноо:".$departed."<br>";
	echo "Монголд очих огноо:".$expected."<br>";
	echo "<p>".$description."</p>";

		if ($status=="new")
		{
	/* SENDER */
		$sender_contact = $_POST["sender_contact"];
		$sender_name = $_POST["sender_name"];
		$sender_surname = $_POST["sender_surname"];
		$sender_email = $_POST["sender_email"];
		$sender_address = $_POST["sender_address"];
		$query_sender = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$sender_contact.'"');
		if ($query_sender->num_rows()==0&&$sender_contact!="")
			{	
			$data = array(
				   'name'=>$sender_name,
				   'surname'=>$sender_surname,
				   'tel'=>$sender_contact ,
				   'email'=>$sender_email,
				   'address'=>$sender_address,
				   'username'=>$sender_contact,
				   'password'=>$sender_contact,
				   'status'=> 'regular'
	            );
			if ($this->db->insert('customer', $data)) ;
			$sender_id=$this->db->insert_id()  ;
			}
		else {
			$row=$query_sender->row();
			$sender_id=$row->customer_id;
			$data = array(
				   'name'=>$sender_name,
				   'surname'=>$sender_surname,
				   'email'=>$sender_email,
				   'address'=>$sender_address,
	            );
			$this->db->where('customer_id', $sender_id);
			$this->db->update('customer', $data);
			}	
	//if (!isset($sender_id)) $sender_id =1;
	/* RECEIVER */
		$receiver_contact = $_POST["receiver_contact"];
		$receiver_name = $_POST["receiver_name"];
		$receiver_surname = $_POST["receiver_surname"];
		$receiver_email = $_POST["receiver_email"];
		$receiver_address = $_POST["receiver_address"];
		$query_receiver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
		if ($query_receiver->num_rows()==0&&$receiver_contact!="")
			{	
			$data = array(
				   'name'=>$receiver_name,
				   'surname'=>$receiver_surname,
				   'tel'=>$receiver_contact ,
				   'email'=>$receiver_email,
				   'address'=>$receiver_address,
				   'username'=>$receiver_contact,
				   'password'=>$receiver_contact,
				   'status'=> 'regular'
	            );
			if ($this->db->insert('customer', $data)) ;
			$receiver_id=$this->db->insert_id();
			}
		else {
			$row=$query_receiver->row();
			$receiver_id=$row->customer_id;
			$data = array(
				   'name'=>$receiver_name,
				   'surname'=>$receiver_surname,
				   'email'=>$receiver_email,
				   'address'=>$receiver_address,
	            );
			$this->db->where('customer_id', $receiver_id);
			$this->db->update('customer', $data);
			}	
		

	 $description=$_POST["description"];
	 $weight=$_POST["weight"];
	 $payment=$_POST["payment"];
	 $pay_in_mongolia=$_POST["pay_in_mongolia"];


	  $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
	do {
	  $barcode='CO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
	  $query = $this->db->query("SELECT barcode FROM container_item WHERE barcode='$barcode'");
	} while ($query->num_rows() == 1); 
	$agent_id=$this->session->userdata("agent_id");



	$data = array(
				   'barcode'=>$barcode,
				   'container'=>$container_id,
				   'sender'=>$sender_id,
				   'receiver'=>$receiver_id,
				   'description'=>$description,
				   'weight'=>$weight,
				   'payment'=> $payment,
				   'pay_in_mongolia'=> $pay_in_mongolia,
				   'agent'=> $agent_id
	            );
		if ($this->db->insert('container_item', $data)) 
		{
			
			$item_id=$this->db->insert_id();	
			echo '<div class="alert alert-success" role="alert">Чингэлэгт ачаа орууллаа</div>';
			log_write("Container-t ачаа нэмэв id =$item_id ".json_encode($data)," container item added");
			echo anchor("agents/container_item_print/".$item_id,"Пайз хэвлэх",array('target'=>"new","class"=>"btn btn-warning"));
		}
			else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</span>';
	}
	else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн дугаар алдаатай байна</div>';

?>