<? if ( !isset($_POST["order_id"])) redirect('orders/track'); else $order_id=$_POST["order_id"]; ?> 

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
	if (isset($_POST["receiver_contact"])) $receiver_contact = $_POST["receiver_contact"]; else $receiver_contact="";
	if (isset($_POST["receiver_name"])) $receiver_name = $_POST["receiver_name"]; else $receiver_name="";
	if (isset($_POST["receiver_surname"])) $receiver_surname = $_POST["receiver_surname"]; else $receiver_surname="";
	if (isset($_POST["receiver_rd"])) $receiver_rd = $_POST["receiver_rd"]; else $receiver_rd=NULL;
	if (isset($_POST["receiver_email"])) $receiver_email = $_POST["receiver_email"]; else $receiver_email=NULL;
	if (isset($_POST["receiver_address"])) $receiver_address = $_POST["receiver_address"]; else $receiver_address="";
	if (isset($_POST["package"])) $package = $_POST["package"]; else $package="";
	if (isset($_POST["price"])) $price = $_POST["price"]; else $price="";


if ($receiver_surname!="" && 
$receiver_name!="" && 
$receiver_rd!="" && 
$receiver_email!="" && 
$receiver_contact!=""&& 
$receiver_address!=""&&
$package!=""&& 
$price!=""
 )

{
$query_receiver = $this->db->query('SELECT customer_id FROM customer WHERE tel="'.$receiver_contact.'"');
if ($query_receiver->num_rows()==0)
{
	$data = array(
			   'name'=>$receiver_name,
			   'surname'=>$receiver_surname,
			   'rd'=>$receiver_rd,
			   'tel'=>$receiver_contact ,
			   'email'=>$receiver_email,
			   'username'=>$receiver_contact ,
			   'password'=>$receiver_contact ,
			   'address'=>$receiver_address,
			   'status'=> 'regular'
            );
			
	if ($this->db->insert('customer', $data)) $receiver_id= $this->db->insert_id()  ;
	//else $receiver_id =1;
}
else { $row=$query_receiver->row();$receiver_id=$row->customer_id;}
//if (!isset($receiver_id)) $receiver_id =1;
$query_order = $this->db->query("SELECT * FROM orders WHERE order_id='".$order_id."'");
if ($query_order->num_rows() == 1)
{
	$row = $query_order->row();
	$barcode=$row->barcode;
	$old_status=$row->status; 
	$old_receiver=$row->receiver; 
	if ($old_status=="order")
	{
		$new_status ="filled";
		$data = array(
					'sender'=>'1',
				   'receiver'=>$receiver_id,
				   'status'=> $new_status,
				   'package'=>$package.'################',
				   'price'=> $price,
				   'is_online'=> 1
					  );
		$this->db->where('order_id', $order_id);
		if ($this->db->update('orders', $data)) 
			{		
				log_write("Үйлчлүүлэгч захиалгыг бүрэн бөглөлөө Barcode:".$barcode." ip:".$_SERVER['REMOTE_ADDR'],"order");
				echo "Илгээмжийг амжилттай бөглөлөө<br>";
			}
			//else echo "Error".$this->db->error();
	}	
	else echo "Илгээмж хүлээн авагчийг бөглөх төлөвт биш байна";
}
else echo "Илгээмжийн дугаар алдаатай байна";
}
else echo "Мэдээлэл дутуу бөглөгдсөн байна.<br><br><input type='button' onclick='window.history.back()' class='button' value='Гүйцэд бөглөнө үү'> <br><br><br>";
echo anchor ("orders/track","Шинэ track хайх",array('class'=>'button',"type"=>"button"));
?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('orders', 'Илгээмжүүд').'</li>
<li>'.anchor('orders/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->