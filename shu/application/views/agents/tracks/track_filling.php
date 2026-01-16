<? if ( !isset($_POST["order_id"])) redirect('orders/track'); else $order_id=$_POST["order_id"]; ?> 

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
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
$query_order = $this->db->query("SELECT * FROM orders WHERE order_id='".$order_id."'");
if ($query_order->num_rows() == 1)
{
	$row = $query_order->row();
	$barcode=$row->barcode;
	$old_status=$row->status; 
	$old_receiver=$row->receiver; 
	if ($old_status=="order" && $old_receiver==1)
	{
	$new_status ="filled";
	$data = array(
			   'receiver'=>$receiver_id,
			   'status'=> $new_status
            	  );
	$this->db->where('order_id', $order_id);
	if ($this->db->update('orders', $data)) 
		{
			$data['tel']= $receiver_contact;
			$data['type']= 'creating';
			$data['barcode']= $barcode;
	
			//$this->load->view("sms/sendsms",$data);
		
			log_write("Үйлчлүүлэгч захиалгыг бүрэн бөглөлөө ".$barcode." ip:".$_SERVER['REMOTE_ADDR'],"order");
			echo "Илгээмжийг амжилттай бөглөлөө";
		}
			else echo "Error".$this->db->error();
	}	
	else echo "Илгээмж хүлээн авагчийг бөглөх төлөвт биш байна";
}
else echo "Илгээмжийн дугаар алдаатай байна";
?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>

<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/tracks', 'Tracks')?></li>
<li><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
<li><?=anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li>
</ul>

</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->