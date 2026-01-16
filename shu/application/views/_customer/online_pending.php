<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='pending' ORDER BY created_date DESC");
		$sum_price=0;
				foreach ($query->result() as $row)
				{  
				$sum_price+=$row->price;
				}
?>

<div class="panel panel-default">
  <div class="panel-heading">Сагс <span style="float:right; color:#F00; font-weight:bold; margin-right:100px;"> <?=$sum_price;?>$</span><span style="float:right;font-weight:bold;">Нийт:&nbsp;&nbsp;&nbsp;</span></div>
  <div class="panel-body">
<?
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>№</th><th>Огноо</th><th>URL</th><th>Тоо</th><th>Хэмжээ</th><th>Өнгө</th><th>Үнэ</th><th>Үйлдэл</th></tr>";
	$i=1;
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
	$price=$row->price;
	$title=$row->title;
	$transport = $row->transport;
	
	echo "<tr>";
	echo "<td>".$i++."</td>";
	
	echo "<td>".substr($created_date,0,10);
		if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 
	echo "</td>";
	if (strlen($title)>50) $title=substr($title,0,50)."...";
	if (strlen($title)==0) $title=substr($url,0,50)."...";
	echo "<td>".anchor($url,$title,array("target"=>"new","title"=>$url))."</td>";	
	echo "<td>".$number."</td>";
	echo "<td>".$size."</td>";
	echo "<td>".$color."</td>";	
	echo "<td>".$price."</td>";
	//echo "<td>".status_comfort($status)."</td>";
	echo "<td>";
	
	if ($status=="online") echo anchor("customer/online_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
	if ($status=="online") echo anchor("customer/online_edit/".$online_id,"Засах",array("class"=>"btn btn-xs btn-warning"));

	echo status_comfort($status);
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



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Үнэ бодох
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Захиалгын үнэ бодох</h4>
      </div>
      <div class="modal-body">
     Бид таны захиалгын үнийг ажлын 6 цагийн дотор бодож захиалганд оруулна. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Хаах</button>
      </div>
    </div>
  </div>
</div>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->



<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<?=base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a>

<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>