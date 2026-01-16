<div class="panel panel-primary">
  <div class="panel-heading">Public Proxy</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM proxies_public");

if ($query->num_rows() >0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><td>№</td><td>Овог</td><td>Нэр</td><td>Утас</td><td>Хаяг</td><td>Үйлдэл</td></tr>";
	$count=1;
	foreach ($query->result() as $row)
	{
	$proxy_id=$row->proxy_id;
	$name=$row->name;
	$surname=$row->surname; 
	$tel=$row->tel; 
	$address=$row->address;
	echo "<tr><td>".$count++."</td>";	
	echo "<td>".$surname."</td>";
	echo "<td>".$name."</td>";
	echo "<td>".$tel."</td>";	
	echo "<td>".$address."</td>";	
	echo "<td>".anchor("admin/proxy_delete/".$proxy_id,"Устгах")."</td></tr>";	
	}
	echo "</table>";
	
}
echo anchor('admin/proxy_add/','Proxy нэмэх',array("class"=>"btn btn-primary"));
echo anchor('admin/proxy_add_excel/','Proxy нэмэх excel',array("class"=>"btn btn-success"));

?>

</div>
</div>
