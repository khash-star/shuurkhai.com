<? if (!$this->uri->segment(3)) redirect('admin/online'); else $online_id=$this->uri->segment(3) ?>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
		$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");
		echo "<table class='table table-hover'>";
		if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$online_id=$row->online_id;
		$created_date=$row->created_date;
		$receiver=$row->receiver;
		$url=$row->url;
		$size=$row->size;
		$color=$row->color;
		$number=$row->number;
		$comment=$row->comment;
		$status=$row->status;
		 
		 echo "<tr>";
	   	 echo "<tr><td>Үүсгэсэн огноо</td><td>".$created_date."</td></tr>"; 
		 echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"name")."(".customer($receiver,"tel").")</td></tr>"; 		
		echo "<tr><td>Барааны веблинк</td><td>".anchor($url,$url,array("target"=>"_new"))."</td></tr>"; 
		echo "<tr><td>Тоо</td><td>".$number."</td></tr>"; 
		echo "<tr><td>Размер</td><td>".$size."</td></tr>"; 
		echo "<tr><td>Өнгө</td><td>".$color."</td></tr>"; 
			}
   			echo "</table>";
?>
</div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">Тайлбарууд</div>
  <div class="panel-body">
  
<?
			//echo $comment;
			
			echo form_open('admin/online_commenting');
			echo form_hidden("online_id",$online_id);			
			echo form_textarea ("comment",$comment,array("class"=>"form-control","placeholder"=>"Comment goes here"));

			echo form_submit("submit","Бичих",array("class"=>"btn btn-success"));
			echo form_close();
?>

</div>
</div>
<?=anchor('admin/online','Бусад',array('class'=>"btn btn-primary"));?>