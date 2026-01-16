<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 

 $name=$_POST["customers_name"];
 $surname=$_POST["customers_surname"];
 $address=$_POST["address"];
 $address_extra=$_POST["address_extra"];
 $contacts=$_POST["contacts"];
 $email=$_POST["email"];
 $rd=$_POST["customers_rd"];

 $city=$_POST["city"];
 $district=$_POST["district"];
 $khoroo=$_POST["khoroo"];
 $build=$_POST["build"];

 	if (isset($_POST["no_proxy"]))	$no_proxy=$_POST["no_proxy"]; else $no_proxy=0;


 if ($contacts=="")  $contacts="++++++";
 else 
  {
	  $data = array(
               'name' => $name,
               'surname' => $surname,
			   'rd' => $rd,
			   'address' =>$address,
			   'address_extra' =>$address_extra,
			   'tel' => $contacts,
			   'email' => $email,
			   'no_proxy' => $no_proxy,
			   'username' => $contacts,
			   'password' => $contacts,
			   
			   'address_city' => $city,
			   'address_district' => $district,
			   'address_khoroo' => $khoroo,
			   'address_build' => $build

	);
 }
 
 $query = $this->db->query("SELECT * FROM customer WHERE tel='$contacts'");
 if ($query->num_rows() == 1)
 {
	$row=  $query->row();
	$customer_id = $row ->customer_id;
	
	$this->db->where('customer_id', $customer_id);
	if ($this->db->update('customer', $data)) echo "Амжилттай заслаа.<br>";
 }
 if ($query->num_rows() == 0)
 {
 if($contacts!="")
 {
	 if($this->db->insert('customer', $data)) 
		{
		echo "Амжилттай нэмлээ";
		echo "<table class='table table-hover'>";
		echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
		echo "<tr><td>РД</td><td>".$rd."</td></tr>";
		echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
		echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
		echo "<tr><td>Нэмэлт мэдээлэл</td><td>".$address_extra."</td></tr>";	
		echo "</table>";
		}
 }
 else echo "Утасны дугаар хоосон байна.";
 }
echo "<br>".anchor ("admin/customers","Үйлчлүүлэгчид")."<br>";

?>
</div>
<div id="clear"></div>
</div>