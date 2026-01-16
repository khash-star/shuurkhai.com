<? if (!$this->uri->segment(3)) redirect('customer/help'); else $help_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM help WHERE (receiver='$customer_id' OR sender='$customer_id') AND help_id='$help_id' LIMIT 1");

if ($query->num_rows()==1)
{
	echo "<table class='table table-hover'>";
	$row= $query->row() ;
	$context=$row->context;
	$timestamp=$row->timestamp; 
	echo "<tr><td>Огноо</td><td>$timestamp</td></tr>";
	echo "<tr><td>Тусламж</td><td>$context</td></tr>";
	echo "</table>";
	$this->db->query("UPDATE help SET `read`=1 WHERE help_id='$help_id' LIMIT 1");
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

