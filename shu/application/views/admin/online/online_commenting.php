<? if (!isset($_POST["online_id"])) redirect('admin/online'); else $online_id=$_POST["online_id"]; ?>
<? if ($_POST["comment"]=="") redirect('admin/online_comment/'.$online_id);else $comment=$_POST["comment"];?>

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
	$comment = $_POST["comment"];
	$sql="UPDATE online SET comment = '$comment' WHERE online_id=$online_id LIMIT 1";
	if($this->db->query($sql))
	echo '<div class="alert alert-success" role="alert">Амжилттай тэмдэглэлээ</div>'; 
	else echo '<div class="alert alert-danger" role="alert">DB error:'.$query->db->error()."'</div>";
	echo anchor('admin/online_comment/'.$online_id,'Буцах',array('class'=>"btn btn-success"));
?>

</div>
</div>
<?=anchor('admin/online','Бусад',array('class'=>"btn btn-primary"));?>