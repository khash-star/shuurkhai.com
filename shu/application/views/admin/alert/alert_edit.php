<? if (!$this->uri->segment(3)) redirect('admin/news'); else $news_id=$this->uri->segment(3); ?>

<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Засах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM news WHERE news_id=".$news_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$title=$row->title;
	$context=$row->context; 

	echo form_open('admin/news_editing');
	echo form_hidden('news_id',$news_id);
	echo form_input ("title",$title,array("class"=>"form-control","placeholder"=>"Гарчиг"))."<br>";
	echo form_textarea ("context",$context,array("class"=>"form-control","placeholder"=>"Мэдээ"))."<br>";
	echo form_submit("submit","засах",array("class"=>"btn btn-success"));
	echo form_close();
	echo anchor("admin/news_deleting/".$news_id,"устгах");

}
else echo "Мэдээ байхгүй";

?>

</div>
</div>