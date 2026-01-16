<div class="panel panel-danger">
  <div class="panel-heading">Хувийн мэдээлэл</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$email=$row->email;
	$username=$row->username;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "<tr><td>Нууц үг</td><td>".anchor('customer/profile_password/','Солих',array('class'=>'btn btn-danger btn-xs'))."</td></tr>";	
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor('customer/profile_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-success"))."<br>"; 
?>
