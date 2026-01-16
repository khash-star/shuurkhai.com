<? if ($this->uri->segment(3)) $track = $this->uri->segment(3); else redirect('orders/track');?>
<? if ($this->uri->segment(4)) $tel = $this->uri->segment(4); else redirect('orders/track_register/'.$track);?>

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
$data = array(
               'name' => $name,
               'surname' => $surname,
			   'rd' => $rd,
			   'address' =>$address,
			   'tel' => $tel,
			   'username' => $tel,
			   'password' => $tel,
			   'email' => $email
	);

 $query = $this->db->query("SELECT * FROM customer WHERE tel='$tel'");
 if ($query->num_rows() == 0)
 {
 if($tel!="" && $name!="" && $surname!="" && $rd!="")
 {
	 if($this->db->insert('customer', $data)) 
		{
		//echo "Амжилттай нэмлээ<br>";
		$customer_id = $this->db->insert_id();
		redirect("orders/track_detail/".$track."/".$tel);
		//echo anchor("customer/online_create/$customer_id","Захиалга",array('class'=>'button'))."<br>";
		}
 }
	
	//$name = $row->name;
	//$surname = $row->surname;
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хэрэглэгч</h4>";
	
	echo "Таны дугаар <b style='font-size:larger'>".substr($surname,0,2).".".$name." </b> нэр дээр бүртгэлтэй байна.<br>";
	echo "</div>";
	
	echo form_open('orders/track_completing/'.$track."/".$tel);
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "Track №<b>".$track."</b>";
	

	$this->table->set_heading(array('Барааны нэр', 'Тоо','Үнэ /$/'));
	
	$this->table->add_row( array(
	form_input ("package1_name"), 
	form_input ("package1_num"), 
	form_input ("package1_value")
	));
	
	$this->table->add_row( array(
	form_input ("package2_name"), 
	form_input ("package2_num"), 
	form_input ("package2_value")
	));
	
	$this->table->add_row( array(
	form_input ("package3_name"), 
	form_input ("package3_num"), 
	form_input ("package3_value")
	));
	
	
	$this->table->add_row( array(
	form_input ("package4_name"), 
	form_input ("package4_num"), 
	form_input ("package4_value")
	));
	echo $this->table->generate(); 

	echo "</div>";
	
	echo form_submit("submit","Хадгал");
	
	

	form_close();
	
	
}

if ($query->num_rows() == 0)
  redirect('customers/register/'.$tel);
?>
</div>
