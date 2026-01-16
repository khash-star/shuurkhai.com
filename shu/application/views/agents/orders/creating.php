<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж оруулах</div>
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
	

$created_date = date("c");
/* Package */
	$package1_name=$_POST["package1_name"];
	$package1_num =$_POST["package1_num"];
	$package1_price =intval($_POST["package1_price"]);
	$package2_name=$_POST["package2_name"];
	$package2_num =$_POST["package2_num"];
	$package2_price =intval($_POST["package2_price"]);
	$package3_name=$_POST["package3_name"];
	$package3_num =$_POST["package3_num"];
	$package3_price =intval($_POST["package3_price"]);
	$package4_name=$_POST["package4_name"];
	$package4_num =$_POST["package4_num"];
	$package4_price =intval($_POST["package4_price"]);
	
	$package_array = array(
	$package1_name, $package1_num,$package1_price,
	$package2_name, $package2_num,$package2_price,
	$package3_name, $package3_num,$package3_price,
	$package4_name, $package4_num,$package4_price
	);
	
	$package =implode("##",$package_array);
	$package_price = $package1_price + $package2_price + $package3_price + $package4_price;

$weight = $_POST["weight"];
$weight=str_replace(",",".",$weight);
$weight=str_replace("kg","",$weight);
$weight=str_replace("Kg","",$weight);
$weight=str_replace("KG","",$weight);
$weight=str_replace("Кг","",$weight);
$weight=str_replace("KГ","",$weight);
$weight=str_replace("кг","",$weight);

//$price = $_POST["price"];
//$third_party = $_POST["third_party"];
//$way = $_POST ["way"];
//$deliver_time = $_POST ["deliver_time"];

/* INSIDE */
//$Package_inside = $_POST["Package_inside"];


/* INSURANCE */
//if (isset($_POST["insurance"]))
//$insurance = $_POST["insurance"];
//else $insurance=0;

//$insurance_value =$_POST["insurance_value"];
/* RETURN TYPE */
//$Package_return_type = $_POST["Package_return_type"];
//$Package_return_address = $_POST["Package_return_address"];
//$Package_return_day = $_POST["Package_return_day"];
//$Package_return_way = $_POST["Package_return_way"];

/* ADVANCE */
if(isset($_POST["Package_advance"])) $Package_advance = 1; else $Package_advance = 0;
if ($Package_advance) $Package_advance_value = round($_POST["Package_advance_value"],2);
else $Package_advance_value="";

  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
$status="new";
if(isset($_POST["transport"])) $transport = 1; else $transport=0;
$agent_id=$this->session->userdata("agent_id");
if ($receiver_id!=1&&$sender_id!=1&$weight !="")
{
$data = array(
			   'created_date'=>$created_date,
			   'barcode'=>$barcode,
			   'package'=>$package,
			   'weight'=>$weight,
			   //'price'=>$price,
               //'description'=>$package_description,
			   'sender'=>$sender_id,
			   'receiver'=>$receiver_id,
			   //'insurance'=>$insurance,
			   //'insurance_value'=>$insurance_value,
			   'advance'=>$Package_advance,
			   'advance_value'=>$Package_advance_value,
			  // 'third_party'=>$third_party,
			  // 'way'=>$way,
			   //'deliver_time'=>$deliver_time,
			  // 'inside'=>$Package_inside,
			  // 'return_type'=>$Package_return_type,
			  // 'return_address'=>$Package_return_address,
			  // 'return_day'=>$Package_return_day,
			  //'return_way'=>$Package_return_way,
			   'transport'=> $transport,
			   'status'=> $status,
			   'agents'=> $agent_id
            );
	if ($this->db->insert('orders', $data)) 
	{
		
		$order_id=$this->db->insert_id();	
		echo '<div class="alert alert-success" role="alert">Илгээмжийг орууллаа</div>';
		echo anchor("agents/preview/".$order_id,"CP72 хэвлэх",array('target'=>"new","class"=>"btn btn-warning"));
	log_write("Order create id =$order_id ".json_encode($data),"order create");

	}
		else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</span>';
}
/*else 
{
	if ($receiver_id==1 || $sender_id==1)
	echo "Хүлээн авагч болон Илгээгчийг АмериканМонгол -р оруулсан байна.<br>";
	echo "Хоосон утгууд байж болохгүй<br>";
	echo "<a href=\"javascript:history.back()\">буцах</a>";
}*/

	

?>

</div>
</div>