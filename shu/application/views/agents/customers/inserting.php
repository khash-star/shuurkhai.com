<div class="panel panel-success">
  <div class="panel-heading">Үйлчлүүлэгч нэмэх</div>
  <div class="panel-body">
<? 
 $name=$_POST["customers_name"];
 $surname=$_POST["customers_surname"];
 $rd=$_POST["customers_rd"];
 $address=$_POST["address"];
 $contacts=$_POST["contacts"];
 $email=$_POST["email"];

 $city=$_POST["city"];
 $district=$_POST["district"];
 $khoroo=$_POST["khoroo"];
 $build=$_POST["build"];

 if ($name!="" && $contacts!="")
 {
	 $query = $this->db->query("SELECT * FROM customer WHERE tel='".$contacts."' OR email='".$email."'");
	 if ($query->num_rows()==0)
	{
	
	$data = array(
               'name' => $name,
               'surname' => $surname,
			   'rd' => $rd,
			   'address' => $address,
			   'tel' => $contacts,
			   'username' => $contacts,
			   'password' => $contacts,
			   'email' => $email,

			   'address_city' => $city,
			   'address_district' => $district,
			   'address_khoroo' => $khoroo,
			   'address_build' => $build

            );
	if($this->db->insert('customer', $data)) 
		{
		echo '<div class="alert alert-success" role="alert">Амжилттай нэмлээ.</div>';
		echo "<table class=\"table table-hover\">";
		echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
		echo "<tr><td>РД</td><td>".$rd."</td></tr>";
		echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
		echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
		echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	

		echo "<tr><td>Аймаг, хот</td><td>".$city_name."</td></tr>";
		echo "<tr><td>Сум, дүүрэг</td><td>".$district_name."</td></tr>";
		echo "<tr><td>Баг, хороо</td><td>".$khoroo."</td></tr>";
		echo "<tr><td>Байр, гудамж</td><td>".$build."</td></tr>";
		
		echo "<tr><td>Нэвтрэх нэр</td><td>".$contacts."</td></tr>";
		echo "<tr><td>Нууц үг</td><td>".$contacts."</td></tr>";
		echo "</table>";
		}
	else //$this->db->insert('customer', $data
		{
		echo '<div class="alert alert-danger" role="alert">Нэмэхэд алдаа гарлаа.</div>';
		echo anchor ("","буцах", array("class"=>"btn btn-xs btn-danger","onclick"=>"window.history.back();"));
		}
	}
	else  //$query->num_rows()==0
	{
	echo '<div class="alert alert-danger" role="alert">Хэрэглэгчийн утас эсвэл и-мэйл бүртгэлтэй байна.</div>';
	echo anchor ("","буцах", array("class"=>"btn btn-xs btn-danger","onclick"=>"window.history.back();"));
	}
 }
 else
 	{
	echo '<div class="alert alert-danger" role="alert">Үйлчлүүлэгч нэмэхэд нэр, утас хоосон байж болохгүй.</div>';
	echo anchor ("","буцах", array("class"=>"btn btn-xs btn-danger","onclick"=>"window.history.back();"));
	}
 ?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor ("agents/customers","Үйлчлүүлэгчид",array("class"=>"btn btn-primary"));?>