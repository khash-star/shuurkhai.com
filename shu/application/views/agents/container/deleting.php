<? if (!$this->uri->segment(3)) redirect('agents/container'); else $container_id=$this->uri->segment(3); ?>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг устгах</div>
  <div class="panel-body">
	<? 
	$query = $this->db->query("SELECT * FROM container_item WHERE container=".$container_id);
	if ($query->num_rows() > 0) echo '<div class="alert alert-danger" role="alert">Чингэлэгт ачаа байна. Чингэлэгээс ачааг бүгдийг гаргаж байгаад устгах боломжтой</div>';
	if ($query->num_rows() == 0) // Чингэлэгт ачаа байхгүй устгаж болно
		{
		if ($this->db->query("DELETE FROM container WHERE container_id=".$container_id)) 
		echo '<div class="alert alert-success" role="alert">Амжилттай устгалаа</div>';
		else echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error.'</div>';
		}
	?>

	</div>
</div>