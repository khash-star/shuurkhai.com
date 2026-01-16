<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгийн ачаанууд</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM container_item WHERE receiver=".$customer_id." AND status NOT IN('delivered','completed') ORDER BY created_date DESC";

$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>№</th><th width='90'>Огноо</th><th>Barcode</th><th>Track</th><th>Жин</th><th>Төлөв</th><th>Үйлдэл</th></tr>";
	$i=$query->num_rows();
	foreach ($query->result() as $row)
	{  
	$item_id=$row->id;
	$weight=$row->weight;
	
	$created_date=$row->created_date;
	$onair_date=$row->onway_date;
	$warehouse_date=$row->warehouse_date;
	$delivered_date=$row->delivered_date;
	
	$transport=$row->transport;

	$barcode=$row->barcode;
	$description=$row->description;
	$package=$row->package;
	
	$sender=$row->sender;
	$receiver=$row->receiver;
	$deliver=$row->deliver;
	
	$track = $row->track;
	

	$status=$row->status;
	$agents=$row->agent;
	$is_online=$row->is_online;
	$proxy=$row->proxy_id;
	
	
	$package_array=explode("##",$package);
	if (count($package_array)>11)
	{
   	$package1_name = $package_array[0];
	$package1_num = $package_array[1];
	$package1_value = $package_array[2];
	$package2_name = $package_array[3];
	$package2_num = $package_array[4];
	$package2_value = $package_array[5];
	$package3_name = $package_array[6];
	$package3_num = $package_array[7];
	$package3_value = $package_array[8];
	$package4_name = $package_array[9];
	$package4_num = $package_array[10];
	$package4_value = $package_array[11];
	}
	
	echo "<tr>";
	echo "<td>".$i--."</td>";
	echo "<td>";
	echo substr($created_date,0,10);
	if ($warehouse_date !="0000-00-00 00:00:00") echo "<br>Агуулахад:<br><span style='color:#F00'>".substr($warehouse_date,0,10)."</span>";
	
	if ($transport) echo "<br><span title='Улаанбаатарт хүргэлттэй'>Хүргэлттэй</span>  ".anchor ("customer/container_transport/".$item_id,"цуцлах",array("class"=>"btn btn-danger btn-xs"));

	else echo "<br>".anchor ("customer/container_transport/".$item_id,"хүргэлт авах",array("class"=>"btn btn-success btn-xs"));

	echo "</td>";
	echo "<td>".anchor("customer/orders_detail/".$receiver,$barcode);
	if ($proxy!=0) echo "<br>".proxy($proxy,"name");
	echo "</td>";
	echo "<td>";
	if ($track!="")
	{
	echo "<a href='".track($track)."' target='_blank' title='Хаана явна'>$track<span class='glyphicon glyphicon-globe'></span></a><br>";
	
	
	$sql_online = "SELECT * FROM online WHERE track='$track'";
	
	$query_online = $this->db->query($sql_online);
	if ($query_online->num_rows() > 0)
		{
			foreach ($query_online->result() as $row_online)
			{  
			$online_id=$row_online->online_id;
			echo anchor(online($online_id,"url"),substr(online($online_id,"title"),0,40)."...")."<span style='color:#F00; font-weight:bold;'> ".online($online_id,"price")."$</span><br>";
			}
		}
	else 
	{
	if ($package1_name!="")
	echo "$package1_name ($package1_num)<br>";
	if ($package2_name!="")
	echo "$package2_name ($package2_num)<br>";
	if ($package3_name!="")
	echo "$package3_name ($package3_num)<br>";
	if ($package4_name!="")
	echo "$package4_name ($package4_num)<br>";
	}
	}
	
	echo "</td>";
	echo "<td>".$weight."</td>";	
	echo "<td>".status_comfort($status)." </td>";
	echo "<td>";
	echo anchor("customer/container_detail/".$item_id,"Дэлгэрэнгүй",array("class"=>"btn btn-xs btn-success"));

	//if ($status=="weight_missing") echo anchor("customer/orders_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
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


<? //$this->load->view("shops");?>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>