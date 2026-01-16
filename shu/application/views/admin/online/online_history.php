<? if ($this->uri->segment(3)) $page=$this->uri->segment(3); else $page=0; ?>
<div class="panel panel-default">
  <div class="panel-heading">Online захиалгын түүх</div>
  <div class="panel-body">
<?
/*if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	echo "Xайлт:".$search_term."<br>";
	} 
	else $search_term = "";
*/

$sql="SELECT * FROM online WHERE status='order' ";
$sql.="ORDER by created_date DESC";
$query = $this->db->query($sql);
$total_online = $query->num_rows();
$sql.=" LIMIT ".$page*50 .",50";
$query = $this->db->query($sql);

if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>№</th><th>Нэр</th><th>URL</th><th>Тоо/Хэмжээ/Өнгө</th><th>Үүсгэсэн/Track</th></tr>";
	$i=$query->num_rows();
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$online_id=$row->online_id;
		$url=$row->url; 
		$size=$row->size; 
		$color=$row->color;
		$number=$row->number;
		$receiver=$row->receiver;
		$track=$row->track;
		$comment=$row->comment;
		$status=$row->status;
		$transport = $row->transport;
		$proceed_date = $row->proceed_date;
		
		$price=$row->price; 
		$tax=$row->tax; 
		$shipping=$row->shipping; 
		
		
		
		echo "<tr>";
		echo "<td>".$i--."</td>";
		echo "<td>".substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name")."<br>";
		echo customer($receiver,"tel");
		if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

		echo  "</td>";	
		//echo "<td>".customer($receiver,"email")."</td>";	
		echo "<td>".anchor($url,substr($url,0,30),array("target"=>"_blank")).".......<br>";
		echo $track."<br>";
			echo '<span style="color:#F00; font-weight:bold;">Үнэ: '.number_format($price,2).'$</span><br>';
			echo '<span style="color:#1079b2; font-weight:bold;">Tax: '.number_format($tax,2).'$</span><br>';
			echo '<span style="color:#f0861b; font-weight:bold;">Shipping: '.number_format($shipping,2).'$</span>';
		echo "</td>";	
		echo "<td>".$number."/".$size."/".$color."</td>";	
		echo "<td>".substr($created_date,0,11)."<br>".substr($proceed_date,0,11)."</td>";
		/*echo "<td>";
		if ($status=="online") 
		echo anchor("admin/online_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
				//	  echo "<td>".$comment."</td>"; 
			echo  anchor('admin/online_comment/'.$online_id,'<span class="glyphicon glyphicon-comment"></span>',array('title'=>$comment,"class"=>"btn btn-xs btn-primary"));
			echo "<br>";
			echo anchor('admin/online_renew/'.$online_id,'<span class="glyphicon glyphicon-transfer"></span>',array('title'=>"Make it order!","class"=>"btn btn-xs btn-success"));
			echo "<br>";
			echo anchor('admin/online_delete/'.$online_id,'<span class="glyphicon glyphicon-trash"></span>',array('title'=>"Устгах","class"=>"btn btn-xs btn-danger")); 
		echo "</td>";
		*/
		echo "</tr>";	
	}
	echo "</table>";

	 $total_pages = floor($total_online/50);
	  for ($i=0; $i<=$total_pages;$i++)
	  {
	  if ($page==$i) echo $i." ";
	  else echo anchor("admin/online_history/$i",$i)." ";
	  }	 
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Онлайн түүх олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>