<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM news ORDER BY timestamp DESC LIMIT 50");

if ($query->num_rows() >0)
{
	echo "<table class='table table-striped'>";
	foreach ($query->result() as $row)
		{
		$news_id=$row->news_id;
		$timestamp=$row->timestamp;
		$title=$row->title;
		$context=$row->context;
		echo "<tr>";
		echo "<td width='200'>";
		echo $timestamp;
		
		echo "<td>";
		
		echo $title;
		echo "<br>";
		echo $context;
		//echo anchor ("customer/help_read/".$help_id,substr($context,0,50)."...");
		echo "</td>";
		
		echo "<td>";
	    echo anchor('admin/news_edit/'.$news_id,'<span class="glyphicon glyphicon-edit"></span>'); 
		echo anchor('admin/news_deleting/'.$news_id,'<span class="glyphicon glyphicon-trash"></span>'); 
		echo "</td>";
		echo "</tr>";
		}
	echo "</table>";
	}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


