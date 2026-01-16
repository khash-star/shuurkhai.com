<div class="panel panel-primary">
  <div class="panel-heading">Мэдээлэл</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM customer WHERE customer_id='$customer_id'");

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$read_news = $row->news_read;
}
$query = $this->db->query("UPDATE customer SET news_read = '".date("Y-m-d H:i:s")."' WHERE customer_id='$customer_id'");
$query = $this->db->query("SELECT * FROM news ORDER BY timestamp DESC LIMIT 50");

if ($query->num_rows() >0)
{
	echo "<table class='table table-striped'>";
	foreach ($query->result() as $row)
		{
		$timestamp=$row->timestamp;
		$title=$row->title;
		$context=$row->context;
		 if ($read_news<$timestamp) $read=1; else $read=0;
		echo "<tr>";
		echo "<td width='200'>";
		if ($read) echo "<b>";
		echo $timestamp;
		if ($read) echo "</b>";
		
		echo "<td>";
		
		if ($read) echo "<b>";
		echo $title;
		if ($read) echo "</b>";
		echo "<br>";
		echo $context;
		//echo anchor ("customer/help_read/".$help_id,substr($context,0,50)."...");
		echo "</td>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


