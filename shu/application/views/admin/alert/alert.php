<div class="panel panel-primary">
  <div class="panel-heading">Нийтийн мэдэгдэл</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT *, count(alert_id) total FROM alert WHERE type=1 GROUP BY context ORDER BY timestamp");

if ($query->num_rows() >0)
{
	$count=1;
	echo "<table class='table table-striped'>";
		echo "<tr>";
		echo "<td>№</td>";
		echo "<td>Мэдэгдэл</td>";
		echo "<td width='200'>Нийт харилцагчид</td>";
		echo "<td width='200'>Нийт харсан</td>";
		echo "<td>Линк</td>";
		echo "</tr>";
	foreach ($query->result() as $row)
		{
		$alert_id = $row->alert_id;
		$total=$row->total;
		$context=$row->context;
		$target=$row->target;
		$query_read = $this->db->query("SELECT * FROM alert WHERE type=1 AND context='$context' AND `read`=1");
		$read_total=$query_read->num_rows();
		echo "<tr>";
		echo "<td>";
		echo $count++;
		echo "</td>";
		echo "<td>";
		echo $context;
		echo "</td>";
		echo "<td width='200'>";
		echo $total;
		echo "</td>";
		echo "<td width='200'>";
		echo $read_total;
		echo "</td>";
		echo "<td>";
		echo $target;
		echo "</td>";
		echo "</tr>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


