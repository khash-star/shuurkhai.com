<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Онлайн Илгээмж</h3>";

/* RECEIVER */
if (isset($_POST["receiver_id"])) $receiver_id=$_POST["receiver_id"]; else $receiver_id="";
if (isset($_POST["receiver_name"])) $receiver_name=$_POST["receiver_name"]; else $receiver_name="";
if (isset($_POST["receiver_surname"])) $receiver_surname=$_POST["receiver_surname"]; else $receiver_surname="";
if (isset($_POST["receiver_rd"])) $receiver_rd=$_POST["receiver_rd"]; else $receiver_rd="";
if (isset($_POST["receiver_email"]) && strpos($_POST["receiver_email"],'@') !== false) $receiver_email=$_POST["receiver_email"]; else $receiver_email="";
if (isset($_POST["receiver_contact"])) $receiver_contact=$_POST["receiver_contact"]; else $receiver_contact="";
if (isset($_POST["receiver_address"])) $receiver_address=$_POST["receiver_address"]; else $receiver_address="";

if (isset($_POST["online_url"])) $online_url=$_POST["online_url"]; else $online_url="";
if (isset($_POST["online_size"])) $online_size=$_POST["online_size"]; else $online_size="";
if (isset($_POST["online_color"])) $online_color=$_POST["online_color"]; else $online_color="";
if (isset($_POST["online_number"])) $online_number=$_POST["online_number"]; else $online_number="";





if ((($receiver_name!=""&&
	$receiver_surname!=""&&
	$receiver_rd!=""&&
	$receiver_email!=""&&
	$receiver_contact!=""&&
	$receiver_address!=""&&
	$online_url!="")||  $receiver_id!="") &&  $online_url!="")
	{
		
	if ($receiver_id=="")
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
				   'address'=>$receiver_address,
				   'status'=> 'regular'
				);
		if ($this->db->insert('customer', $data)) $receiver_id= $this->db->insert_id();
	}
	else {$row=$query_receiver->row(); $receiver_id=$row->customer_id;}
	}
	else {
		$query_receiver = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$receiver_id.'"');
		$row=$query_receiver ->row();
		$receiver_contact=$row->tel;
		$receiver_name=$row->name;
		$receiver_surname=$row->surname;
	}


// ONLINE

	$data = array(
			   'created_date'=>date("c"),
			   'url'=>$online_url,
			   'size'=>$online_size,
			   'color'=>$online_color ,
			   'number'=>$online_number,
			   'receiver'=>$receiver_id,
			   'title'=>$title,
			   'status'=> 'regular'
            );
	if ($this->db->insert('online', $data)) 
	{
	$online_id=$this->db->insert_id();
	log_write("Үйлчлүүлэгч online № ".$online_id." Илгээмж ".$receiver_contact." дугаарт ".$online_url." хаягыг Илгээмжд орууллаа ip:".$_SERVER['REMOTE_ADDR'],"order");
	echo "Таны захиалгыг хүлээн авлаа.<br>";
	echo anchor("online/online_create/".$receiver_id,"ахин нэмэх",array("class"=>"button"));
	
	}
	else echo "Error".$this->db->error();
}

else {
	echo "Мэдээлэл алдаатай байна<br>";
	echo "-Хэрэглэгчийн мэдээлэл хоосон байх<br>";
	echo "-Утас болон Mail зөв бөглөгдсөн байх<br>";
	echo "<a href='#' onclick='window.history.back()' class='button'>Буцах</a>";
	}
?>

</div><!--content-->

<div id="right_side">
<? $this->load->view("left_content");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('online', 'Илгээмжүүд').'</li>
<li>'.anchor('online/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>

</div><!--wrapper-->
