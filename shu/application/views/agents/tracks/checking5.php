<? if (!isset($_POST["track"])) redirect("agents/insert"); else $track=$_POST["track"];?>
<div class="panel panel-primary">
  <div class="panel-heading">Track: дуусгах</div>
  <div class="panel-body">
<? 
	$track = string_clean($track);
	
	$contact =$_POST["contact"];
	$name =$_POST["name"];
	$address =$_POST["address"];
	
	$data = array(
		'name'=>$name,
		'tel' => $contact,
		'address'=> $address,
		'username'=> $contact,
		'password'=> $contact
				);
	if($this->db->insert('customer', $data)) 
	$receiver=$this->db->insert_id();	
		
				
	$track_eliminated = substr($track,-8,8);


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
	$package1_name, $package1_num, $package1_price,
	$package2_name, $package2_num, $package2_price,
	$package3_name, $package3_num, $package3_price,
	$package4_name, $package4_num, $package4_price
	);
	
	$package =implode("##",$package_array);
	$package_price = $package1_price + $package2_price + $package3_price + $package4_price;
	
	$order_id=trachhsearch($track);
	if ($order_id!="")
	{
		$query = $this->db->query("SELECT * FROM orders WHERE order_id = 'order_id'");

		$row = $query->row();
		$order_id=$row->order_id;
		$new_status='new';
		$data = array(
		'receiver' =>$receiver,
		'package'=>$package,
		'price' => $package_price,
		'status'=> $new_status
				);

		$this->db->where('order_id', $order_id);
		
		if ($this->db->update('orders', $data))
		echo anchor('agents/tracks_preview/'.$order_id,'CP72 print',array('target'=>"_blank",'class'=>'btn btn-warning'))."<br>";
		else echo '<div class="alert alert-danger" role="alert">Алдаа:'.$this->db-error().'</div>';
		echo "<br>";
		echo anchor('agents/tracks_mini/'.$order_id,'Mini print',array('target'=>"_blank",'class'=>'btn btn-danger'))."<br>";
	}
		else echo '<div class="alert alert-danger" role="alert">Track not registered</div>';
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->
