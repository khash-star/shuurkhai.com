<? if (!$_POST["online_id"]) redirect('online_orders/online'); else $online_id=$_POST["online_id"]; ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT online.*,customer.tel AS tel,customer.name AS receiver_name FROM online LEFT JOIN customer ON online.receiver=customer.customer_id WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
	{
	foreach ($query->result() as $row)
			{  
			$created_date=$row->created_date;
			$receiver_id=$row->receiver;
			$receiver_contact=$row->tel;
			$receiver_name=$row->receiver_name;
			$url=$row->url;
			$size=$row->size;
			$color=$row->color;
			$number=$row->number;
			//$status=$row->status;

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
			$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
			
			if ($receiver_id==1) $status="order"; 
			if ($weight=="") $status="weight_missing";
			if ($receiver_id!=1 && $weight!="") $status="new";
			
			$data = array(
			   'created_date'=>$created_date,
			   'barcode'=>$barcode,
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
			if ($this->db->insert('online_orders', $data)) 
				{
					$order_id=$this->db->insert_id();
					//MSG SENDING
					$data["online_order_id"]=$order_id;
		//$this->load->view("sms/sendsms",$data);
		
					//MAIL SENDING
					//$data['online_order_id']=$order_id;
		////$this->load->view('mail/mail_send',$data);
					echo "Илгээмжийг орууллаа";
				}
			else echo "Error".$this->db->error();
			}
	} 
	else "Online дугаар алдаатай байна";
	?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('online_orders', 'Илгээмжүүд')?></li>
<li><?=anchor('online_orders/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->