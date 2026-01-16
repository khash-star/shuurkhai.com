<? if (!$this->uri->segment(3)) redirect('customer/orders'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Идэвхитэй захиалгууд</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM orders WHERE order_id=$order_id";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{
	echo "<table class='table table-hover'>";

	$order_id=$row->order_id;
	$weight=$row->weight;
	$weight =str_replace("kg","",strtolower($weight));
	$price=$row->price;
	
	
	$created_date=$row->created_date;
	$onair_date=$row->onair_date;
	$warehouse_date=$row->warehouse_date;
	$delivered_date=$row->delivered_date;
	
	
	$barcode=$row->barcode;
	$package=$row->package;
	$price=$row->price;
	
	$sender=$row->sender;
	$receiver=$row->receiver;
	$deliver=$row->deliver;
	
	$insurance=$row->insurance;
	$insurance_value=$row->insurance_value;
	$advance=$row->advance;
	$advance_value=$row->advance_value;
	$third_party=$row->third_party;
	
	$way=$row->way;
	$deliver_time=$row->deliver_time;
	$inside=$row->inside;
	$return_type=$row->return_type;
	$return_day=$row->return_day;
	$return_way=$row->return_way;
	$return_address=$row->return_address;
	
	$extra=$row->extra;
	$timestamp=$row->timestamp;
	$status=$row->status;
	$agents=$row->agents;
	$is_online=$row->is_online;
	$proxy = $row->proxy_id;
	
	$package_array=explode("##",$package);
			$package1_name = $package_array[0];
			$package1_num = $package_array[1];
			$package1_price = $package_array[2];
			$package2_name = $package_array[3];
			$package2_num = $package_array[4];
			$package2_price = $package_array[5];
			$package3_name = $package_array[6];
			$package3_num = $package_array[7];
			$package3_price = $package_array[8];
			$package4_name = $package_array[9];
			$package4_num = $package_array[10];
			$package4_price = $package_array[11];
	
		
	echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>";
	if ($third_party!="")
	echo "<tr><td>Track</td><td>".$third_party."</td></tr>";
	
	//echo "<tr><td>Үүсгэсэн</td><td>".$created_date."</td></tr>";
	if ($onair_date!="0000-00-00 00:00:00")
	echo "<tr><td>Америкаас наашаа гарсан</td><td>".$onair_date."</td></tr>";
	if ($warehouse_date!="0000-00-00 00:00:00")
	echo "<tr><td>Агуулахад ирсэн</td><td>".$warehouse_date."</td></tr>";
	echo "<tr><td>Илгээгч</td><td>".customer($sender,"full_name")."</td></tr>";
	echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"full_name")."</td></tr>";
	if ($proxy!=0) echo "<tr><td>Хэн авах</td><td>".proxy($proxy,"name")."</td></tr>" ;
	if ($status=='delivered')
	echo "<tr><td>Гардан авсан (огноо)</td><td>".customer($deliver,"full_name")." (".$delivered_date.")</td></tr>";
	if ($status!='weight_missing')
	echo "<tr><td>Жин (төлбөр)</td><td>".$weight."кг &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ".cfg_price($weight)."$ )</td></tr>";
	if ($status!='delivered')
	echo "<tr><td>Хугацаа</td><td>".days($created_date)." хоног</td></tr>";
	//if ($advance)
	//echo "<tr><td>Үлдэгдэл төлбөр</td><td>$advance_value $</td></tr>";
	if ($package1_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num) - $package1_price $</td></tr>";
	if ($package2_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num) - $package2_price $</td></tr>";
	if ($package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num) - $package3_price $</td></tr>";
	if ($package4_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num) - $package4_price $</td></tr>";
	echo "<tr><td>Төлөв</td><td>".status_comfort($status)."</td></tr>";
	echo "</table>";
	if ($status=='weight_missing')
	echo anchor("customer/orders_deleting/".$order_id,"Устгах",array("class"=>"btn btn-danger btn-xs"));
	echo "&nbsp;";
	if ($status=='weight_missing')
	echo anchor("customer/orders_edit/".$order_id,"Засах",array("class"=>"btn btn-warning btn-xs"));
	}
	else
	//if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{echo '<div class="alert alert-danger" role="alert">Таньд хамааралгүй илгээмж.</div>';}
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("customer/orders","Миний илгээмж",array("class"=>"btn btn-success"));?>