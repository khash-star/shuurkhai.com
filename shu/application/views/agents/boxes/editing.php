<? if ($_POST["customer_id"]=="") redirect('agents/customers_display'); else $customer_id=$_POST["customer_id"]; ?>


<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$_POST["name"];
	$customer_id=$_POST["customer_id"];
	$surname=$_POST["surname"]; 
	$rd=$_POST["rd"]; 
	$contacts=$_POST["contacts"];
	$address=$_POST["address"];
	$email=$_POST["email"];
	
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
    echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";

	$data = array(
               'name' => $name,
			   'surname' => $surname,
			   'rd' => $rd,
			   'tel' => $contacts,
			   'address' => $address,
			   'email' => $email
            );
	$this->db->where('customer_id', $customer_id);
	if ($this->db->update('customer', $data)) echo "Амжилттай заслаа.<br>";
	else echo "ERROR".$this->db->error();

}
else echo "Үйлчлүүлэгч олдоогүй";

?>

</div>

<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents/customers', 'Үйлчлүүлэгчид')?></li>
<li><?=anchor('agents/customers_insert', 'Үйлчлүүлэгч оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->