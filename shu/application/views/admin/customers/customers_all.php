<div class="panel panel-primary">
  <div class="panel-heading">Бүх хэрэглэгч</div>
  <div class="panel-body">
<? 
//$total_costumers = $this->db->count_all('customer');
//echo "Нийт бүртгэлтэй хэрэглэгч:".$total_costumers."<br>";
//$sql= "SELECT * FROM customer";

{
$sql= "SELECT * FROM customer";
$query = $this->db->query($sql);
$total_costumers = $query->num_rows($sql);
$query = $this->db->query($sql);
$count=$query->num_rows();
if ($count > 0)
{
	$count=$query->num_rows();
	echo "<table class='table table-hover'>";
	echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th width='300px'>Э-мэйл</th>"; 
	   echo "<th width='300px'>Хаяг</th>"; 
	   echo "</tr>";
	   
	foreach ($query->result() as $row)
	{  echo "<tr>";
	   echo "<td>".$count--."</td>";
	   echo "<td>".substr($row->surname,0,2).".".$row->name."</td>"; 
 	   echo "<td>".$row->tel."</td>"; 
	   echo "<td width='300px'>";
	   if ($row->email!="")
	   echo mailto($row->email,$row->email,array("title"=>$row->email));
	   echo "</td>"; 
		echo "<td width='300px'>".$row->address."<br>".$row->address_extra."</td>"; 
	   echo "</tr>";
	} 

	echo "</table>";
}
else echo '<div class="alert alert-danger" role="alert">Хэрэглэгч олдоогүй</div>';
}

?>
</div>
</div>