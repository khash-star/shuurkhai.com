<? if (!$this->uri->segment(3)) redirect('admin/customers'); else $customer_id=$this->uri->segment(3) ?>


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
	$no_proxy=$row->no_proxy;
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
  <div class="panel-heading">Proxy</div>
  <div class="panel-body">
<? 
if ($no_proxy)
	{
		echo '<div class="alert alert-danger" role="alert">Proxy авдаггүй дугаар</div>';
	}
	else 
	{
		$query = $this->db->query("SELECT * FROM proxies WHERE customer_id=".$customer_id);

		if ($query->num_rows() >0)
		{
			echo "<table class='table table-hover'>";
			echo "<tr><td>№</td><td>Овог</td><td>Нэр</td><td>Утас</td><td>Хаяг</td><td>Авах боломж</td><td colspan='2'>Үйлдэл</td></tr>";
			$count=1;
			foreach ($query->result() as $row)
			{
			$proxy_id=$row->proxy_id;
			$name=$row->name;
			$surname=$row->surname; 
			$tel=$row->tel; 
			$address=$row->address;
			$status=$row->status;
			if ($status==0) $status="тийм"; else $status="үгүй";
			echo "<tr><td>".$count++."</td>";	
			echo "<td>".$surname."</td>";
			echo "<td>".$name."</td>";
			echo "<td>".$tel."</td>";	
			echo "<td>".$address."</td>";	
			echo "<td>".$status."</td>";	
			echo "<td>".anchor("admin/customers_proxy_edit/".$customer_id.'/'.$proxy_id,"Засах")."</td>";	
			echo "<td>".anchor("admin/customers_proxy_delete/".$proxy_id,"Устгах")."</td></tr>";	
			}
			echo "</table>";
			
		}
		echo anchor('admin/customers_proxy_add/'.$row->customer_id,'Proxy нэмэх',array("class"=>"btn btn-primary"));
		echo anchor('admin/customers_proxy_add_excel/'.$row->customer_id,'Proxy нэмэх excel',array("class"=>"btn btn-success"));
	}

?>

</div>
</div>
