<? if ($_POST["customer_id"]=="") redirect('agents/customers_display'); else $customer_id=$_POST["customer_id"]; ?>


<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
 	$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

	if ($query->num_rows() == 1)
	{
	$name=$_POST["name"];
	$customer_id=$_POST["customer_id"];
	$surname=$_POST["surname"]; 
	$rd=$_POST["rd"]; 
	$contacts=$_POST["contacts"];
	$address=$_POST["address"];
	$email=$_POST["email"];

	$city=$_POST["city"];
	$district=$_POST["district"];
	$khoroo=$_POST["khoroo"];
	$build=$_POST["build"];


	//$username=$_POST["username"];
	//$password=$_POST["password"];
	$sql="UPDATE customer SET surname='$surname',rd='$rd',email='$email',address='".$address."',address_city='$city',address_district='$district',address_khoroo='$khoroo',address_build='$build' WHERE customer_id=$customer_id LIMIT 1";
	if ($this->db->query($sql))
	{
		echo '<div class="alert alert-success" role="alert">Амжилттай заслаа.</div>';
		echo "<table class='table table-hover'>";
		echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
		echo "<tr><td>РД</td><td>".$rd."</td></tr>";
		echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
		echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
		//echo "<tr><td>Нэвтрэх нэр</td><td>".$username."</td></tr>";
		//echo "<tr><td>Нууц үг</td><td>".$password."</td></tr>";
		echo "</table>";
	}
	else echo '<div class="alert alert-danger" role="alert">Засалтад алдаа гарлаа:'.$this->db->error().'</div>'; 
	}
	else echo '<div class="alert alert-danger" role="alert">Хэрэглэгчийн мэдээлэл олдсонгүй</div>'; 
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?
log_write("Customer Edit id =$customer_id SET TO surname='$surname',rd='$rd',email='$email',address='".$address."'","customer edit");
?>
