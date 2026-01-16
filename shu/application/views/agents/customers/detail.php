<? if (!$this->uri->segment(3)) redirect('agents/customers'); else $customer_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT customer.*,city.name AS city_name,district.name AS district_name FROM customer 
LEFT JOIN city ON customer.address_city=city.id
LEFT JOIN district ON customer.address_district=district.id
WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$city_name=$row->city_name;
	$district_name = $row->district_name;
	$khoroo = $row->address_khoroo;
	$build = $row->address_build;
	//$username=$row->username;
	//$password=$row->password;
	$email=$row->email;
	echo "<table class='table table-hover'>";
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

	//echo "<tr><td>Нэвтрэх нэр</td><td>".$username."</td></tr>";
	//echo "<tr><td>Нууц үг</td><td>".$password."</td></tr>";
	echo "</table>";
	echo anchor('agents/customers_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-primary"));
}
else echo "Үйлчлүүлэгч байхгүй";

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->