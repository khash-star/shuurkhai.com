<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Онлайн Илгээмж</h3>";

/* RECEIVER */
if ((isset($_POST["receiver_name"])&&
	isset($_POST["receiver_surname"])&&
	isset($_POST["receiver_rd"])&&
	isset($_POST["receiver_email"])&&
	isset($_POST["receiver_contact"])&&
	isset($_POST["receiver_address"])&&
	isset($_POST["online_url"]))||
	isset($_POST["receiver_id"])
	)
	{
if (!isset($_POST["receiver_id"]))
{
$receiver_surname = $_POST["receiver_surname"];
$receiver_name = $_POST["receiver_name"];
$receiver_rd = $_POST["receiver_rd"];
$receiver_email = $_POST["receiver_email"];
$receiver_contact = $_POST["receiver_contact"];
$receiver_address = $_POST["receiver_address"];

$query_receiver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
if ($query_receiver->num_rows()==0)
{
	$data = array(
			   'name'=>$receiver_name,
			   'surname'=>$receiver_surname,
			   'rd'=>$receiver_rd,
			   'tel'=>$receiver_contact ,
			   'email'=>$receiver_email,
			   'address'=>$receiver_address,
			   'status'=> 'regular'
            );
	if ($this->db->insert('customer', $data)) $receiver_id= $this->db->insert_id();
}
else {$row=$query_receiver->row(); $receiver_id=$row->customer_id;}
}
else {
	$receiver_id = $_POST["receiver_id"];
	$query_receiver = $this->db->query('SELECT tel FROM customer WHERE customer_id="'.$receiver_id.'"');
	$row=$query_receiver ->row();
	$receiver_contact=$row->tel;
}


// ONLINE
if (isset($_POST["online_url"])) $online_url = $_POST["online_url"]; 


if ($receiver_id!=1 && $online_url!="")
{
	$online_number = $_POST["online_number"];
	$online_size = $_POST["online_size"];
	$online_color = $_POST["online_color"];
	$data = array(
			   'created_date'=>date("c"),
			   'url'=>$online_url,
			   'size'=>$online_size,
			   'color'=>$online_color ,
			   'number'=>$online_number,
			   'receiver'=>$receiver_id,
               //'country'=>'MONGOLIA',
			   'status'=> 'regular'
            );
	if ($this->db->insert('online', $data)) 
	{
	$online_id=$this->db->insert_id();
	//$data['online_id']=$online_id;
	////$this->load->view('mail/mail_send',$data);
	log_write("Үйлчлүүлэгч online № ".$online_id." Илгээмж ".$receiver_contact." дугаарт ".$online_url." хаягыг Илгээмжд орууллаа ip:".$_SERVER['REMOTE_ADDR'],"order");
	echo "Таны захиалгыг хүлээн авлаа.<br>";
	echo anchor("online_orders/online_create/".$receiver_id,"ахин нэмэх");
	
	}
	else echo "Error".$this->db->error();


}

else echo "Барааны Веблинк эсвэх Үйлчлүүлэгчийн мэдээлэл хоосон байна";
	}
	else 
?>

</div><!--content-->

<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('online_orders', 'Илгээмжүүд').'</li>
<li>'.anchor('online_orders/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>

</div><!--wrapper-->
