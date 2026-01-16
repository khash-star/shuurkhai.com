<? if ($_POST["news_id"]=="") redirect('admin/news'); else $news_id=$_POST["news_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Засах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM news WHERE news_id=".$news_id);

if ($query->num_rows() == 1)
{
	$title=$_POST["title"];
	$context=$_POST["context"];
	
	$data = array(
               'title' => $title,
			   'context' => $context
            );
	$this->db->where('news_id', $news_id);
	if ($this->db->update('news', $data)) echo "Амжилттай заслаа.<br>";
	else echo "ERROR".$this->db->error();

}
else echo "Мэдээ олдоогүй";

?>

</div>
</div>