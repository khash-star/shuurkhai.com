<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг</div>
  <div class="panel-body">
<? 
/*$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');*/


$sql="SELECT * FROM container WHERE status NOT IN ('delivered') ORDER BY created DESC";
$query = $this->db->query($sql);
$total_weight =0;

if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover table-striped'>";
	 echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Үүсгэсэн</th>"; 
	   echo "<th>Төлөв</th>";
	   echo "<th>Доторхи ачаа</th>"; 
	   echo "<th>Монголд</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	foreach ($query->result() as $row)
	{ 
	   	$container_id= $row->container_id; 
	   	$name= $row->name; 
	   	$created= $row->created;
	   	$status = $row->status;
	   	$expected = $row->expected;
	
	   echo "<tr>";
	   echo "<td>".$count++."</td>";
	   echo "<td>".$name."</td>"; 
	   echo "<td>".$created."</td>"; 
	   echo "<td>".$status."</td>"; 
		echo "<td>";
		$sql="SELECT * FROM container_item WHERE container=$container_id";
		$query_container = $this->db->query($sql);
		echo $query_container->num_rows();
		echo "</td>"; 
		echo "<td>".$expected."</td>"; 

 		echo "<td>".anchor('agents/container_detail/'.$container_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   	echo "</tr>";	   
	}
	echo "</table>";
}
else echo '<div class="alert alert-danger" role="alert">No container</div>';

echo anchor ("agents/container_insert","Чингэлэг үүсгэх",array("class"=>"btn btn-success"));
	


?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->