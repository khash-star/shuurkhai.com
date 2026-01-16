<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 

 $name=$_POST["customers_name"];
 $surname=$_POST["customers_surname"];
 $tel=$_POST["contacts"];
 $address=$_POST["address"];
 $email=$_POST["email"];
 $rd=$_POST["customers_rd"];
	if (isset($_POST["no_proxy"]))	$no_proxy=$_POST["no_proxy"]; else $no_proxy=0;

$data = array(
               'name' => $name,
               'surname' => $surname,
			   'rd' => $rd,
			   'address' =>$address,
			   'tel' => $tel,
			   'username' => $tel,
			   'password' => $tel,
			   'email' => $email,
			   'no_proxy'=>$no_proxy
	);

 $query = $this->db->query("SELECT * FROM customer WHERE tel='$tel'");
 if ($query->num_rows() == 1)
 {
	echo "Бүртгэлэтэй байна.<br>";
	echo anchor ("customers/pre_order/".$tel,"Захиалга",array("class"=>'button'));
 }
 if ($query->num_rows() == 0)
 {
 if($tel!="" && $name!="" && $surname!="" && $rd!="")
 {
	 if($this->db->insert('customer', $data)) 
		{
		echo "Амжилттай нэмлээ<br>";
		$customer_id = $this->db->insert_id();
		redirect("customers/pre_order2/".$tel,'refresh',3);
		//echo anchor("customer/online_create/$customer_id","Захиалга",array('class'=>'button'))."<br>";
		}
 }
 else echo "Утасны дугаар, овог нэр, РД, и-мэйл хоосон байна."."<br>";
 }
echo anchor ("#","Буцах",array('onclick'=>'javascript:history.back(-1);','class'=>'button'))."<br>";

?>
</div>
<div id="clear"></div>
</div>