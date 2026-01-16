<? if ($this->uri->segment(3)) $page=$this->uri->segment(3); else $page=0; ?>

<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
//$total_costumers = $this->db->count_all('customer');
//echo "Нийт бүртгэлтэй хэрэглэгч:".$total_costumers."<br>";
//$sql= "SELECT * FROM customer";

if (isset($_POST["search"]) && $_POST["search"]!="") 
{
$sql= "SELECT * FROM customer";
$sql.=" WHERE CONCAT_WS(name,surname,tel,rd,email,username) LIKE '%".$_POST["search"]."%'";
$query = $this->db->query($sql);
$total_costumers = $query->num_rows($sql);
$sql.=" LIMIT ".$page*50 .",50";
$query = $this->db->query($sql);
$count=$query->num_rows();
if ($count > 0)
{
	$count=$query->num_rows();
	echo "<table class='table table-hover'>";
	echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   //echo "<th>Овог</th>"; 
	  // echo "<th>РД</th>"; 
	   echo "<th>Утас</th>"; 
	   //echo "<th>Э-мэйл</th>"; 
	   echo "<th>Хаяг</th>"; 
	   echo "<th>Үйлдэл</th>"; 
	   echo "</tr>";
	   //$count=$total_costumers - $page*50;
	   
	foreach ($query->result() as $row)
	{  echo "<tr>";
	   echo "<td>".$count--."</td>";
	   echo "<td>".substr($row->surname,0,2).".".$row->name."</td>"; 
	  // echo "<td>".$row->surname."</td>"; 
	  // echo "<td>".$row->rd."</td>"; 
 	   echo "<td>".$row->tel."</td>"; 
	  // echo "<td>".$row->email."</td>"; 
	   echo "<td>".$row->address."<br>".$row->address_extra."</td>"; 
	   echo "<td>";
	   if ($row->email!="")
	   echo mailto($row->email,'<span class="glyphicon glyphicon-envelope"></span>',array("title"=>$row->email));
	   echo anchor('admin/customers_detail/'.$row->customer_id,'<span class="glyphicon glyphicon-edit"></span>',array("title"=>"дэлгэрэнгүй"));
	   if ($row->no_proxy)
	   	echo '<span class="glyphicon glyphicon-education" title="Proxy авдаггүй дугаар"></span>';
	   else
	   	echo anchor('admin/customers_proxy/'.$row->customer_id,'<span class=" glyphicon glyphicon-education"></span>',array("title"=>"proxy"));
	   echo "</td>"; 
	   echo "</tr>";
	} 

	echo "</table>";

	 $total_pages = floor($total_costumers/50);
	  for ($i=0; $i<=$total_pages;$i++)
	  {
	  if ($page==$i) echo $i." ";
	  else echo anchor("admin/customers/$i",$i)." ";
	  }	 
}
else echo '<div class="alert alert-danger" role="alert">Хэрэглэгч олдоогүй</div>';
}

?>
</div>
</div>