<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
echo "Agents:".$this->db->count_all('agents')."<br>";
$query = $this->db->query("SELECT * FROM agents");
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	 echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Username</th>"; 
	   //echo "<th>РД</th>"; 
	   echo "<th>Last log</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	foreach ($query->result() as $row)
	{  echo "<tr>";
	   echo "<td>".$count++."</td>";
	   echo "<td>".$row->name."</td>"; 
	   echo "<td>".$row->username."</td>"; 
	   echo "<td>".$row->last_log."</td>"; 
	   echo "<td>".anchor('admin/agents_edit/'.$row->agent_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	} 
	echo "</table>";
}
else echo '<div class="alert alert-danger" role="alert">Агент олдсонгүй</div>';

?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->