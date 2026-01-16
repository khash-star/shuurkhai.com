<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<?=base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a>

<a href="<?=base_url();?>index.php/welcome/help" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Шинээр үүсгэх</a>

<div class="clearfix"></div><br />
<div class="panel panel-primary">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM help WHERE receiver=".$customer_id." ORDER BY timestamp DESC");

if ($query->num_rows() >0)
{
	echo "<table class='table table-hover'>";
	foreach ($query->result() as $row)
		{
		$context=$row->context;
		$help_id=$row->help_id;
		$timestamp=$row->timestamp; 
		$read=$row->read; 
		echo "<tr>";
		echo "<td>$timestamp</td>";
		
		echo "<td>";
		if (!$read) echo "<b>";
		echo anchor ("customer/help_read/".$help_id,$context);
		if (!$read) echo "</b>";
		echo "</td>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


