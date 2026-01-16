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
$search = str_replace(" ","%",$_POST["search"]);
$sql.=" WHERE CONCAT_WS(name,surname,tel) LIKE '%".$search."%'";
$query = $this->db->query($sql);
$total_costumers = $query->num_rows($sql);
$sql.=" LIMIT ".$page*50 .",50";
$query = $this->db->query($sql);
$count=$query->num_rows();
if ($query->num_rows() > 0)
{
	echo "<table class=\"table table-hover\">";
	 echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   //echo "<th>Овог</th>"; 
	  // echo "<th>РД</th>"; 
	   echo "<th>Утас</th>"; 
	   //echo "<th>Э-мэйл</th>"; 
	   echo "<th>Хаяг</th>"; 
	   echo "<th></th>"; 
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
	   echo "<td>".$row->address."</td>"; 
	   echo "<td>";
	   if ($row->email!="")
	   echo mailto($row->email,'<span class="glyphicon glyphicon-envelope"></span>',array("title"=>$row->email));
	   echo anchor('agents/customers_detail/'.$row->customer_id,'<span class="glyphicon glyphicon-edit"></span>');
	   echo "</td>"; 
	   echo "</tr>";
	} 
	echo "</table>";
		 $total_pages = floor($total_costumers/50);
	  for ($i=0; $i<=$total_pages;$i++)
	  {
	  if ($page==$i) echo $i." ";
	  else echo anchor("agents/customers/$i",$i)." ";
	  }	 

}
else echo '<div class="alert alert-danger" role="alert">Үйлчлүүлэгч байхгүй</div>';
}

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->