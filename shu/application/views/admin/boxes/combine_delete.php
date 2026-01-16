<? if (!$this->uri->segment(3)) redirect('agents/combine'); else $combine_id=$this->uri->segment(3); ?>

<div class="panel panel-success">
  <div class="panel-heading">Нэгтгэсэн ачаа-г устгах</div>
  <div class="panel-body">
<? 
	
	if ($this->db->query("DELETE FROM box_combine WHERE combine_id=".$combine_id)) 
		echo "Амжилттай устгалаа";
		else "Error:".$this->db->error;
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->