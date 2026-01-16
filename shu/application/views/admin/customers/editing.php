<? if ($_POST["customer_id"]=="") redirect('admin/customers'); else $customer_id=$_POST["customer_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
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
	$address_extra=$_POST["address_extra"];
	$email=$_POST["email"];

	$city=$_POST["city"];
	$district=$_POST["district"];
	$khoroo=$_POST["khoroo"];
	$build=$_POST["build"];


	if (isset($_POST["no_proxy"]))	$no_proxy=$_POST["no_proxy"]; else $no_proxy=0;
	$username=$_POST["username"];
	$password=$_POST["password"];
	$sql="UPDATE customer SET surname='$surname',rd='$rd',email='$email',address='".$address."',address_city='$city',address_district='$district',address_khoroo='$khoroo',address_build='$build',no_proxy='".$no_proxy."',username='".$username."',password='".$password."',name='".$name."',address_extra='".$address_extra."' WHERE customer_id=$customer_id LIMIT 1";
	if ($this->db->query($sql))
	{
		$query=$this->db->query("SELECT * FROM customer WHERE customer_id=$customer_id");
		$data=$query->row();
		echo '<div class="alert alert-success" role="alert">Амжилттай заслаа.</div>';
		echo "<table class='table table-hover'>";
		echo "<tr><td>Нэр</td><td>".$data->name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$data->surname."</td></tr>";
		echo "<tr><td>РД</td><td>".$data->rd."</td></tr>";
		echo "<tr><td>Утас</td><td>".$data->tel."</td></tr>";	
		echo "<tr><td>Э-мэйл</td><td>".$data->email."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".$data->address."</td></tr>";
		echo "<tr><td>Нэмэлт мэдээлэл</td><td>".$data->address_extra."</td></tr>";
		echo "<tr><td>Proxy авахгүй</td><td>".$data->no_proxy."</td></tr>";	
		echo "<tr><td>Нэвтрэх нэр</td><td>".$data->username."</td></tr>";
		echo "<tr><td>Нууц үг</td><td>".$data->password."</td></tr>";
		echo "</table>";
		if ($contacts!=""&& $data->tel!=$contacts)
		{
		$sql  = "SELECT * FROM customer WHERE tel='".$contacts."'";
		//echo $sql;
		$query=$this->db->query($sql);
		if ($query->num_rows()==0)
		if ($this->db->query("UPDATE customer SET tel='$contacts' WHERE customer_id=$customer_id LIMIT 1"))
		echo '<div class="alert alert-success" role="alert">Мэдээллийг бүрэн заслаа</div>';
		else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</div>';
		else echo '<div class="alert alert-danger" role="alert">Утас бүртгэлтэй. Бусад мэдээллийг зассан.</div>';
		}
	}
	else echo '<div class="alert alert-danger" role="alert">Засалтад алдаа гарлаа:'.$this->db->error().'</div>';
	echo anchor("admin/customers_edit/".$customer_id,"Ахин засах",array("class"=>"btn btn-primary")) ;
	}
	else echo '<div class="alert alert-danger" role="alert">Хэрэглэгчийн мэдээлэл олдсонгүй</div>'; 
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
