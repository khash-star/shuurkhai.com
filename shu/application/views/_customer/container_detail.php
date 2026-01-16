<? if (!$this->uri->segment(3)) redirect('customer/orders'); else $item_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгийн дэлгэрэнгүй</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM container_item WHERE id=$item_id";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{
	echo "<table class='table table-hover'>";

	$weight=$row->weight;
	$weight =str_replace("kg","",strtolower($weight));
	
	$created_date=$row->created_date;
	$onway_date=$row->onway_date;
	$warehouse_date=$row->warehouse_date;
	$delivered_date=$row->delivered_date;
	
	
	$barcode=$row->barcode;
	$track=$row->track;
	$package=$row->package;

	$sender=$row->sender;
	$receiver=$row->receiver;
	$deliver=$row->deliver;
	$container = $row->container;
	$expected_date=$row->expected_date;
	$description = $row->description;
	$status=$row->status;
	$agents=$row->agent;
	$is_online=$row->is_online;
	$transport=$row->transport;
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
	if ($track!="")
	echo "<tr><td>Track</td><td>".$track."</td></tr>";
	
	//echo "<tr><td>Үүсгэсэн</td><td>".$created_date."</td></tr>";
	if ($onway_date!="0000-00-00 00:00:00")
	echo "<tr><td>Америкаас наашаа гарсан</td><td>".$onway_date."</td></tr>";
	if ($warehouse_date!="0000-00-00 00:00:00")
	echo "<tr><td>Агуулахад ирсэн</td><td>".$warehouse_date."</td></tr>";
	echo "<tr><td>Илгээгч</td><td>".customer($sender,"full_name")."</td></tr>";
	echo "<tr><td>Хүлээн авагч</td><td>".customer($receiver,"full_name")."</td></tr>";
	if ($proxy!=0) echo "<tr><td>Хэн авах</td><td>".proxy($proxy,"name")."</td></tr>" ;
	if ($status=='delivered')
	echo "<tr><td>Гардан авсан (огноо)</td><td>".customer($deliver,"full_name")." (".$delivered_date.")</td></tr>";
	if ($status!='weight_missing')
	echo "<tr><td>Жин</td><td>".$weight."кг</td></tr>";


	echo "<tr><td>Чингэлэг</td><td>";
	if ($container==0)  echo "Одоогоор чингэлэгт ороогүй байна";
	if ($container!=0) 
		{
			$sql_container = "SELECT * FROM container WHERE container_id='$container'";
			$result_container = mysqli_query($conn,$sql_container);
			$data_container = mysqli_fetch_array ($result_container);
			echo $data_container["name"]." ирэх хугацаа: ".$data_container["expedted"];
		}
	echo "</td></tr>";
	if ($package1_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num) - $package1_price $</td></tr>";
	if ($package2_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num) - $package2_price $</td></tr>";
	if ($package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num) - $package3_price $</td></tr>";
	if ($package4_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num) - $package4_price $</td></tr>";

	if ($description!="") echo "<tr><td>Нэмэлт тайлбар</td><td>$description</td></tr>";

	echo "<tr><td>Төлөв</td><td>".status_comfort($status)."</td></tr>";
	echo "</table>";

	



	if ($status=='weight_missing')
	echo anchor("customer/container_deleting/".$item_id,"Устгах",array("class"=>"btn btn-danger btn-xs"));
	echo "&nbsp;";
	if ($status=='weight_missing')
	echo anchor("customer/container_edit/".$item_id,"Засах",array("class"=>"btn btn-warning btn-xs"));
	}
	else
	//if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{echo '<div class="alert alert-danger" role="alert">Таньд хамааралгүй илгээмж.</div>';}
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Чингэлэгийн ачаа олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("customer/container","Чинэглэгийн ачаа",array("class"=>"btn btn-success"));?>