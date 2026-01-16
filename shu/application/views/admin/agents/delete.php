<? if (!$this->uri->segment(3)) redirect('admin/agents'); else $agent_id=$this->uri->segment(3); ?>


<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM agents WHERE agent_id=".$agent_id);

if ($query->num_rows() == 1)
{
		if ($this->db->query("DELETE FROM agents WHERE agent_id=".$agent_id)) 
		echo '<div class="alert alert-success" role="alert">Амжилттай устгалаа</div>';
		else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error.'</div>';

}
else echo '<div class="alert alert-danger" role="alert">Агент олдсонгүй</div>';
?>

  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->