<script>window._epn = {campaign:5338036725};</script>
<script src="https://epnt.ebay.com/static/epn-smart-tools.js"></script>
<? 
$customer_id = $this->session->userdata('customer_id');
$query = $this->db->query("SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status ='online' AND price!=0 ORDER BY created_date DESC");
		$sum_price=0;
		$sum_tax=0;
		$sum_shipping=0;
		$sum_num =$query->num_rows();
				foreach ($query->result() as $row)
				{  
				$sum_price+=$row->price;
				$sum_tax+=$row->tax;
				$sum_shipping+=$row->shipping;
				}
?>

<div class="panel panel-default">
  <div class="panel-heading">Сагс <span style="float:right; font-weight:bold; margin-right:100px;">Item (<?=$sum_num;?>)<span style="color:#090;"> <?=$sum_price;?>$</span>  Tax:<span style="color:#090;"><?=$sum_tax;?>$</span> Ship:<span style="color:#090;"><?=$sum_shipping;?>$</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Нийт:&nbsp; <span style="color:#090;"><?=$sum_price+$sum_tax+$sum_shipping;?>$ (<?=cfg_rate()*($sum_price+$sum_tax+$sum_shipping);?>₮)</span></span></div>
  <div class="panel-body">
<?
$query = $this->db->query("SELECT * FROM online WHERE (customer_id='".$customer_id."' OR receiver='".$customer_id."') AND status = 'online' ORDER BY created_date DESC");

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
	$tax=$row->tax;
	$shipping=$row->shipping;
	$title=$row->title;
	$comment=$row->comment;
	$transport = $row->transport;
	
	echo "<tr>";
	echo "<td>".$i++."</td>";
	
	echo "<td>".substr($created_date,0,10);
	if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй ".anchor ("customer/online_transport/".$online_id,"цуцлах",array("class"=>"btn btn-danger btn-xs")); 
	else echo "<br>".anchor ("customer/online_transport/".$online_id,"хүргэлт авах",array("class"=>"btn btn-success btn-xs"));
	echo "</td>";
	if (strlen($title)>50) $title=substr($title,0,50)."...";
	if (strlen($title)==0) $title=substr($url,0,50)."...";
	echo "<td>".anchor($url,$title,array("target"=>"new","title"=>$url))."</td>";	
	echo "<td>".$number."</td>";
	echo "<td>".$size."</td>";
	echo "<td>".$color."</td>";	
	echo "<td>";
	if ($price>0)
	echo '<span style="color:#090; font-weight:bold;">'.$price.'$</span>';
	else {	if ($comment!="") echo $comment; else echo "-";	}
	echo "</td>";
	//echo "<td>".status_comfort($status)."</td>";
	echo "<td>";
	
	if ($status=="online") echo anchor("customer/online_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
	if ($status=="online") echo anchor("customer/online_edit/".$online_id,"Засах",array("class"=>"btn btn-xs btn-warning"));
	if ($status=="online") echo anchor("customer/online_later/".$online_id,"Хойшлуулах",array("class"=>"btn btn-xs btn-primary"));

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
  Төлбөр хийх
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
   Үнийн дүн нь бодогдсон барааг зөвшөөрвөл төлбөрөө дансанд хийснээр захиалга баталгаажна. Хэрэв эс зөвшөөрвөл та сагснаасаа захиалгаа устгах эсвэл хойшлуулж дараа худалдан авалт хийж болно. Төлбөр хийхдээ гүйлгээний утгад утасны дугаар оруулна уу. <br />
   Төгрөгийн данс: Хаан банк 5753899300 Хашбал<br /> 
   Лавлах утас: 99037509
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
