<?  $customer_id=$_POST["customer_id"]; ?>

<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$username=$row->username;
	$password=$row->password;
	$email=$row->email;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";
	echo anchor('admin/customers_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-primary"));
}
?>

</div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">Proxy нэмэх</div>
  <div class="panel-body">
<? 

 $name=$_POST["proxy_name"];
 $surname=$_POST["proxy_surname"];
 $address=$_POST["proxy_address"];
 $contacts=$_POST["proxy_contacts"];

 if ($contacts!="" && $surname!="" &&  $address!="" && $contacts!="" && $customer_id!="") 
 {
	  $data = array(
	  			'customer_id'=>$customer_id,
               'name' => $name,
               'surname' => $surname,
			   'address' =>$address,
			   'tel' => $contacts,
	);

	 if($this->db->insert('proxies', $data)) 
		{
		echo "Амжилттай нэмлээ";
		echo "<table class='table table-hover'>";
		echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
		echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
		echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
		echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
		echo "</table>";
		echo anchor ("admin/customers_proxy/".$customer_id,"Бүх Proxy",array("class"=>"btn btn-primary"));
		}
 }
 else 
 {
	 echo "Аль нэг талбар хоосон байна.";
	 echo anchor ("admin/customers_proxy_add/".$customer_id,"Ахин оролдох",array("class"=>"btn btn-primary"));
 }

?>
</div>
<div id="clear"></div>
</div>

<?=anchor("admin/customers_proxy/".$customer_id,"Бүх proxy",array("class"=>"btn btn-primary")); ?>