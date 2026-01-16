<? if (!$this->uri->segment(3)) redirect('admin/news'); else $news_id=$this->uri->segment(3); ?>


<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Устгах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM news WHERE news_id=".$news_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$title=$row->title;
	$context=$row->context; 

	if ($this->db->query("DELETE FROM news WHERE news_id=".$news_id)) echo "Амжилттай устгалаа";
		else "Error:".$this->db->error;

		
}
else echo "Мэдээ олдоогүй";

?>

</div>
</div>