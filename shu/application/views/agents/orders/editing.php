<? if ($_POST["order_id"]=="") redirect('orders'); else $order_id=$_POST["order_id"]?>

<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж засах</div>
  <div class="panel-body">
<? 

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
	
	


/* Package */
	$package1_name=$_POST["package1_name"];
	$package1_num =$_POST["package1_num"];
	$package1_price =$_POST["package1_price"];
	$package2_name=$_POST["package2_name"];
	$package2_num =$_POST["package2_num"];
	$package2_price =$_POST["package2_price"];
	$package3_name=$_POST["package3_name"];
	$package3_num =$_POST["package3_num"];
	$package3_price =$_POST["package3_price"];
	$package4_name=$_POST["package4_name"];
	$package4_num =$_POST["package4_num"];
	$package4_price =$_POST["package4_price"];
	
	$package_array = array(
	$package1_name, $package1_num,$package1_price,
	$package2_name, $package2_num,$package2_price,
	$package3_name, $package3_num,$package3_price,
	$package4_name, $package4_num,$package4_price
	);
	
	$package =implode("##",$package_array);


	$weight = $_POST["weight"];
	$barcode = $_POST["barcode"];
	if(isset($_POST["transport"])) $transport = 1; else $transport=0;
	if (!isset($_POST["Package_advance"])) $Package_advance=0; else $Package_advance = 1;
	
	$Package_advance_value = $_POST["Package_advance_value"];


$sql = "SELECT * FROM orders WHERE order_id='".$order_id."' LIMIT 1";
$query = $this->db->query($sql);
if ($query->num_rows()==1)
{
	$row = $query ->row();
	if ($row->is_online!="1" && $row->agents==$this->session->userdata('agent_id') && $row->status=="new")
	{
$data = array(
			   'barcode'=>$barcode,
			   'package'=>$package,
			   'weight'=>$weight,
			   'sender'=>$sender_id,
			   'receiver'=>$receiver_id,
			   'advance'=>$Package_advance,
			   'advance_value'=>$Package_advance_value,
			    'transport'=>$transport,
            );
	$this->db->where('order_id', $order_id);
	if ($this->db->update('orders', $data)) 
		{
			echo "Амжилттай заслаа.<br>";
			log_write("Order edit id =$order_id ".json_encode($data),"order edit");

		}
	else echo "ERROR".$this->db->error();
	}
	else echo "Захиалгыг засах боломжгүй."; 
}
else echo "Захиалга олдсонгүй";
	
	
	

?>

</div>
</div>