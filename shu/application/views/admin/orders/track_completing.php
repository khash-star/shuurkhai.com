<? if ($this->uri->segment(3)) $track = $this->uri->segment(3); else redirect('orders/track');?>
<? if ($this->uri->segment(4)) $tel = $this->uri->segment(4); else redirect('orders/track_register/'.$track);?>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?
	$query = $this->db->query("SELECT * FROM customer WHERE tel='".$tel."' LIMIT 1");
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$customer_id = $row->customer_id ;
	
	$name = $row->name;
	$surname = $row->surname;
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хэрэглэгч</h4>";
	
	echo "Таны дугаар <b style='font-size:larger'>".substr($surname,0,2).".".$name." </b> нэр дээр бүртгэлтэй байна.<br>";
	echo "</div>";
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	
	
	
	$third_party = $track;
	
	$barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
do {
  $barcode='GO'.date("ymd").sprintf("%03d",rand(000,999)).'MN';
  $query = $this->db->query("SELECT order_id FROM orders WHERE barcode='$barcode'");
} while ($query->num_rows() == 1); 
	$status="weight_missing";
	/* Package */
	$package1_name = $_POST["package1_name"];
	$package1_num = $_POST["package1_num"];
	$package1_produced = 'USA';
	$package1_weight = '';
	$package1_value = $_POST["package1_value"];
	if ($package1_value=="" && $package1_name!="") $package1_value =rand(10,200);
	$package2_name = $_POST["package2_name"];
	$package2_num = $_POST["package2_num"];
	$package2_produced = 'USA';
	$package2_weight = '';
	$package2_value = $_POST["package2_value"];
	if ($package2_value=="" && $package2_name!="") $package2_value =rand(10,200);	
	$package3_name = $_POST["package3_name"];
	$package3_num = $_POST["package3_num"];
	$package3_produced = 'USA';
	$package3_weight = '';
	$package3_value = $_POST["package3_value"];
	if ($package3_value=="" && $package3_name!="") $package3_value =rand(10,200);		
	$package4_name = $_POST["package4_name"];
	$package4_num = $_POST["package4_num"];
	$package4_produced = 'USA';
	$package4_weight = '';
	$package4_value = $_POST["package4_value"];
	if ($package4_value=="" && $package4_name!="") $package4_value =rand(10,200);	
	$package_array = array(
	$package1_name, $package1_num, $package1_produced,$package1_weight,$package1_value,
	$package2_name, $package2_num, $package2_produced,$package2_weight,$package2_value,
	$package3_name, $package3_num, $package3_produced,$package3_weight,$package3_value,
	$package4_name, $package4_num, $package4_produced,$package4_weight,$package4_value
	);
	
	$package =implode("##",$package_array);
	$query_track = $this->db->query("SELECT * FROM orders WHERE SUBSTRING(third_party,-7,7) = '".substr($third_party,-7,7)."' LIMIT 1");

	if ($query_track->num_rows() == 0)
	{
	$data = array(
			   'created_date'=>date("c"),
			   'package' =>$package,
			   'receiver' =>$customer_id,
			   'barcode'=> $barcode,
			   'third_party' => $third_party,
			   'status'=> $status,
			   'is_online'=> 1,
            );
	if ($this->db->insert('orders', $data)) 
			{
			echo "Track № <b>".$track."</b> амжилттай бүртгэгдэж <b>".$barcode."</b> дугаартай боллоо.";
			}
	}
	echo "</div>";
}

?>
</div>


