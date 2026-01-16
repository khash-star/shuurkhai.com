<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
/* SENDER */
$sender_surname = $_POST["sender_surname"];
$sender_name = $_POST["sender_name"];
$sender_rd = $_POST["sender_rd"];
$sender_email = $_POST["sender_email"];
$sender_contact = $_POST["sender_contact"];
$sender_address = $_POST["sender_address"];
$query_sender = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$sender_contact.'"');
if ($query_sender->num_rows()==0&&($sender_contact!=""||$sender_rd!=""))
{
	$data = array(
			   'name'=>$sender_name,
			   'surname'=>$sender_surname,
			   'rd'=>$sender_rd,
			   'tel'=>$sender_contact ,
			   'email'=>$sender_email,
			   'address'=>$sender_address,
               //'country'=>'MONGOLIA',
			   'status'=> 'regular'
            );
	if ($this->db->insert('customer', $data)) ;
	$sender_id=$this->db->insert_id()  ;
}
else {foreach ($query_sender->result() as $row){$sender_id=$row->customer_id;}}	
if (!isset($sender_id)) $sender_id =1;
/* RECEIVER */
$receiver_surname = $_POST["receiver_surname"];
$receiver_name = $_POST["receiver_name"];
$receiver_rd = $_POST["receiver_rd"];
$receiver_email = $_POST["receiver_email"];
$receiver_contact = $_POST["receiver_contact"];
$receiver_address = $_POST["receiver_address"];

$query_receiver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
if ($query_receiver->num_rows()==0&&($receiver_contact!=""||$receiver_rd!=""))
{
	$data = array(
			   'name'=>$receiver_name,
			   'surname'=>$receiver_surname,
			   'rd'=>$receiver_rd,
			   'tel'=>$receiver_contact ,
			   'email'=>$receiver_email,
			   'address'=>$receiver_address,
               //'country'=>'MONGOLIA',
			   'status'=> 'regular'
            );
	if ($this->db->insert('customer', $data)) ;
	$receiver_id= $this->db->insert_id()  ;
}
else {foreach ($query_receiver->result() as $row){$receiver_id=$row->customer_id;}}
if (!isset($receiver_id)) $receiver_id =1;
$created_date = date("c");
/* Package */
$package1_name = $_POST["package1_name"];
$package1_num = $_POST["package1_num"];
$package1_produced = $_POST["package1_produced"];
$package1_weight = $_POST["package1_weight"];
$package1_value = $_POST["package1_value"];
if ($package1_value=="" && $package1_name!="") $package1_value =rand(10,200);

$package2_name = $_POST["package2_name"];
$package2_num = $_POST["package2_num"];
$package2_produced = $_POST["package2_produced"];
$package2_weight = $_POST["package2_weight"];
$package2_value = $_POST["package2_value"];
if ($package2_value=="" && $package2_name!="") $package2_value =rand(10,200);

$package3_name = $_POST["package3_name"];
$package3_num = $_POST["package3_num"];
$package3_produced = $_POST["package3_produced"];
$package3_weight = $_POST["package3_weight"];
$package3_value = $_POST["package3_value"];
if ($package3_value=="" && $package3_name!="") $package3_value =rand(10,200);

$package4_name = $_POST["package4_name"];
$package4_num = $_POST["package4_num"];
$package4_produced = $_POST["package4_produced"];
$package4_weight = $_POST["package4_weight"];
$package4_value = $_POST["package4_value"];
if ($package4_value=="" && $package4_name!="") $package4_value =rand(10,200);

$package_array = array(
$package1_name, $package1_num, $package1_produced,$package1_weight,$package1_value,
$package2_name, $package2_num, $package2_produced,$package2_weight,$package2_value,
$package3_name, $package3_num, $package3_produced,$package3_weight,$package3_value,
$package4_name, $package4_num, $package4_produced,$package4_weight,$package4_value
);

$package =implode("##",$package_array);

//$package_description= mysql_escape_string($_POST["package_description"]);

$weight = $_POST["weight"];
$price = $_POST["price"];
//$third_party = $_POST["third_party"];
$way = $_POST ["way"];
$deliver_time = $_POST ["deliver_time"];

/* INSIDE */
$Package_inside = $_POST["Package_inside"];


/* INSURANCE */
if (isset($_POST["insurance"]))
$insurance = $_POST["insurance"];
else $insurance=0;

$insurance_value =$_POST["insurance_value"];
/* RETURN TYPE */
$Package_return_type = $_POST["Package_return_type"];
$Package_return_address = $_POST["Package_return_address"];
$Package_return_day = $_POST["Package_return_day"];
$Package_return_way = $_POST["Package_return_way"];

/* ADVANCE */
$Package_advance = $_POST["Package_advance"];
if ($Package_advance) $Package_advance_value = $_POST["Package_advance_value"];
else $Package_advance_value="";
$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
$status="new";
if ($receiver_id!=1&&$sender_id!=1&$weight !="" && $price !="")
{
$data = array(
			   'created_date'=>$created_date,
			   'barcode'=>$barcode,
			   'package'=>$package,
			   'weight'=>$weight,
			   'price'=>$price,
               //'description'=>$package_description,
			   'sender'=>$sender_id,
			   'receiver'=>$receiver_id,
			   'insurance'=>$insurance,
			   'insurance_value'=>$insurance_value,
			   'advance'=>$Package_advance,
			   'advance_value'=>$Package_advance_value,
			  // 'third_party'=>$third_party,
			   'way'=>$way,
			   'deliver_time'=>$deliver_time,
			   'inside'=>$Package_inside,
			   'return_type'=>$Package_return_type,
			   'return_address'=>$Package_return_address,
			   'return_day'=>$Package_return_day,
			   'return_way'=>$Package_return_way,
			   'status'=> $status,
			   'agents' => 0
			   
            );
	if ($this->db->insert('orders', $data)) 
	{
		$order_id=$this->db->insert_id();
		//MSG SENDING
		$data["order_id"]=$order_id;
		//$this->load->view("sms/sendsms",$data);
		
		//MAIL SENDING
		$data['order_id']=$order_id;
		//$this->load->view('mail/mail_send',$data);
	
		echo "Илгээмжийг орууллаа";
	}
		else echo "Error".$this->db->error();
}else 
{
	echo "Хоосон утгууд байж болохгүй<br>";
	echo "<a href=\"javascript:history.back()\">буцах</a>";
}

	

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