<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM help WHERE sender IS NULL ORDER BY timestamp DESC");

if ($query->num_rows() >0)
{	

		echo "<table class='table table-hover'>";
		echo "<tr><th>Огноо</th><th>Хэнээс</th><th>Утас</th><th>Email</th><th>Тусламж</th><th>Үйлдэл</th>";
		foreach ($query->result() as $row)
			{
			$context=$row->context;
			$help_id=$row->help_id;
			$receiver=$row->receiver;
			$timestamp=$row->timestamp; 
			echo "<tr>";
			echo "<td>$timestamp</td>";
			echo "<td>".customer($receiver,"name")."</td>";
			echo "<td>".customer($receiver,"tel")."</td>";
			echo "<td>".mailto(customer($receiver,"email"),customer($receiver,"email"))."</td>";
			echo "<td>";
			echo anchor ("admin/help_read/".$help_id,substr($context,0,50)."...");
			echo "</td>";
			echo "</tr>";
			}
		echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

