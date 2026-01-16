<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM help WHERE sender=".$customer_id." ORDER BY timestamp DESC");

if ($query->num_rows() >0)
{
	echo "<table class='table table-hover'>";
	foreach ($query->result() as $row)
		{
		$help_id=$row->help_id;
		$context=$row->context;
		$timestamp=$row->timestamp; 
		echo "<tr>";
		echo "<td>$timestamp</td>";
		
		echo "<td>";
		echo anchor ("customer/help_read/".$help_id,substr($context,0,50)."...");
		echo "</td>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

