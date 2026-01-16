<? if ($this->session->userdata('login')||$this->session->userdata('agent_login')) 
	{
$sql="SELECT * FROM comments ORDER BY timestamp DESC";
//echo $sql;
$query = $this->db->query($sql);
//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	foreach ($query->result() as $row)
	{  
		$timestamp=$row->timestamp;
		$author=$row->author;
		$comment=$row->comment;
		echo "<div class=\"comments\">";
		echo "<span class=\"comments_author\">".$author." </span>";
		echo "<span class=\"comments_timestamp\">".$timestamp.": </span>";
		echo "<span class=\"comments_comment\"> ".$comment."</span>";
		echo "</div>";
	}
}
		



	echo "<div id=\"comment\">";
	echo "<h3>Comments</h3>";
	echo form_open("defaults/commenting");
	echo form_textarea("comment")."<br>";
	echo form_submit("submit","бичих");
	echo form_close();
	

	echo "</div>"; 
	}
	
?>