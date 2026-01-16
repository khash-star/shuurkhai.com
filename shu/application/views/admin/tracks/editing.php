<? if ($_POST["order_id"]=="") redirect('agents/tracks'); else $order_id=$_POST["order_id"];?>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
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
$third_party = $_POST["third_party"];
//if($third_party=="") $third_party=NULL;
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
$Package_advance_value = $_POST["Package_advance_value"];
//$barcode='CP'.date("ymd").sprintf("%03d",rand(000,999)).'MN';

if ($receiver_id==1) $status="order";
if ($weight=="") $status="weight_missing"; 
if ($package=="################") $status="item_missing"; 
if ($receiver_id!=1 && $weight!="") $status="new"; 

$data = array(
			   'created_date'=>$created_date,
			   'package'=>$package,
			   'weight'=>$weight,
			   'price'=>$price,
			   'receiver'=>$receiver_id,
			   'insurance'=>$insurance,
			   'insurance_value'=>$insurance_value,
			   'advance'=>$Package_advance,
			   'advance_value'=>$Package_advance_value,
			   'third_party'=>$third_party,
			   'way'=>$way,
			   'deliver_time'=>$deliver_time,
			   'inside'=>$Package_inside,
			   'return_type'=>$Package_return_type,
			   'return_address'=>$Package_return_address,
			   'return_day'=>$Package_return_day,
			   'return_way'=>$Package_return_way,
			   'status'=> $status
            );
	$this->db->where('order_id', $order_id);
	if ($this->db->update('orders', $data)) 
	{
		echo "Амжилттай заслаа.<br>";
		if ($status=="new")  echo anchor('tracks/preview/'.$order_id,'Хэвлэх',array('target'=>"new"))."<br>";
	}
	
	else echo "ERROR".$this->db->error();
	
	
	

?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->