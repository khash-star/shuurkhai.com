<div class="panel panel-default">
  <div class="panel-heading">Захиалгын түүх</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status IN ('complete','order')");

if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>№</th><th>Огноо</th><th>URL</th><th>Тоо</th><th>Хэмжээ</th><th>Өнгө</th></tr>";
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
	$transport=$row->transport;

	
	
	echo "<tr>";
	echo "<td>".$i++."</td>";
	echo "<td>".substr($created_date,0,10);
	if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

	echo "</td>";
	if (strlen($title)>50) $title=substr($title,0,50)."...";
	if (strlen($title)==0) $title=substr($url,0,50)."...";

	echo "<td>".anchor($url,$title,array("target"=>"new"))."<br>";
	if ($track!="")
	echo "<a href='".track($track)."' target='_blank' title='Хэзээ хүргэгдсэн'>$track<span class='glyphicon glyphicon-globe'></span></a><br>";
	
	if (track2order($track,"order_id")!="")
	echo "Barcode:".anchor("customer/orders_detail/".track2order($track,"order_id"),track2order($track,"barcode"),array("target"=>'_blank'));
	
	
	echo "</td>";	
	echo "<td>".$number."</td>";
	echo "<td>".$size."</td>";
	echo "<td>".$color."</td>";	
	//echo "<td>".status_comfort($status)."</td>";
	echo "<td>";
	
	if ($status=="online") echo "Track:".anchor("customer/online_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
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