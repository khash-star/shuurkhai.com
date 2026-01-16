<? if (!$this->uri->segment(3)) redirect('customers/display'); else $customer_id=$this->uri->segment(3); ?>


<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd;
	$contacts=$row->tel;
	$address=$row->address;
	$email=$row->email;
	
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
    echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";



		if ($this->db->query("DELETE FROM customer WHERE customer_id=".$customer_id)) 
		echo '<div class="alert alert-success alert-dismissible" role="alert">Амжилттай устгалаа</div>';
		else '<div class="alert alert-danger alert-dismissible" role="alert">Error'.$this->db->error.'</div>';

}
else echo '<div class="alert alert-danger alert-dismissible" role="alert">Үйлчлүүлэгч олдсонгүй</div>';

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("admin/customers","Бүх хэрэглэгч",array("class"=>"btn btn-primary"));