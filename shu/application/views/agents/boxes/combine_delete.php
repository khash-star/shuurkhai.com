<? if (!$this->uri->segment(3)) redirect('agents/combine'); else $combine_id=$this->uri->segment(3); ?>

<div class="panel panel-success">
  <div class="panel-heading">Нэгтгэсэн ачаа-г устгах</div>
  <div class="panel-body">
<? 
	$sql="SELECT * FROM box_combine WHERE combine_id='".$combine_id."'";
	$query = $this->db->query($sql);
	if ($query->num_rows() ==1)
	{
		$data= $query->row();
		$status = $data->status;
		if ($status!="warehouse" && $status!="delivered" && $status!="onair")
		{
			if ($this->db->query("DELETE FROM box_combine WHERE combine_id=".$combine_id)) 
			echo "Амжилттай устгалаа";
			else "Error:".$this->db->error;
		}
		else echo "Устгах боломжгүй";
	}
	else echo "Нэгтгэл олдсонгүй";
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->