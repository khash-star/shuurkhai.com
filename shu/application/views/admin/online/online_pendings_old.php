<div class="panel panel-default">
  <div class="panel-heading">Online захиалгууд</div>
  <div class="panel-body">
<?

$sql="SELECT * FROM online";
$sql.=" WHERE status='pending'";
$sql.=" ORDER by online_id DESC";

$query = $this->db->query($sql);

if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>№</th><th>Огноо</th><th>Нэр/Утас</th><th>URL/Тоо/Хэмжээ/Өнгө</th><th>Коммент</th><th width='130'>Үйлдэл</th></tr>";
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
	$title=$row->title;
	$price=$row->price;
	
	
	echo "<tr>";
	echo "<td>".$i--."</td>";
	echo "<td>".substr($created_date,0,10)."</td>";
	echo "<td>";
	echo anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"));
	if (customer($receiver,"email")!="") 
	echo mailto(customer($receiver,"email"), ' <span class="glyphicon glyphicon-envelope"></span>');
	echo"<br>";
	echo customer($receiver,"tel")."</td>";	
	//echo "<td>".customer($receiver,"email")."</td>";	
	echo "<td>".anchor($url,substr($url,0,20),array("target"=>"_blank")).".......<br>";	
	echo $number."/".$size."/".$color."<br>";
	echo '<span style="color:#F00; font-weight:bold;">'.$price.'$</span>';
	echo "</td>";	
	echo "<td>".$comment."</td>";	
	//echo "<td>".status_comfort($status)."</td>";
	echo "<td>";
		echo  anchor('admin/online_price/'.$online_id,'<span class="glyphicon glyphicon-usd"></span> Үнэ',array('title'=>$comment,"class"=>"btn btn-xs btn-primary btn-shuurkhai"));

		echo  anchor('admin/online_comment/'.$online_id,'<span class="glyphicon glyphicon-comment"></span> Бичих',array('title'=>$comment,"class"=>"btn btn-xs btn-primary btn-shuurkhai"));
		echo "<br>";
		echo anchor('admin/online_renew/'.$online_id,'<span class="glyphicon glyphicon-transfer"></span> Захиалга',array('title'=>"Make it order!","class"=>"btn btn-xs btn-success btn-shuurkhai"));
		
		echo anchor('admin/online_track_renew/'.$online_id,'<span class="glyphicon glyphicon-transfer"></span> Track',array('title'=>"Only Give Track!","class"=>"btn btn-xs btn-warning btn-shuurkhai"));
		echo "<br>";
		echo anchor('admin/online_delete/'.$online_id,'<span class="glyphicon glyphicon-trash"></span> Устгах',array('title'=>"Устгах","class"=>"btn btn-xs btn-danger btn-shuurkhai")); 
		
	echo "</td>";
	echo "</tr>";	
	}
	echo "</table>";
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->