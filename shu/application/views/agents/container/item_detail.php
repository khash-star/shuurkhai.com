<? if (!$this->uri->segment(3)) redirect('agents/container'); else $item_id=$this->uri->segment(3) ?>
<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгт буй ачааны дэлгэрэнгүй</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$sender= 	$row ->sender;
	$receiver= 	$row ->receiver;
	$description = $row ->description;
	$weight= 	$row ->weight;
	$payment= 	$row ->payment;
	$pay_in_mongolia= 	$row ->pay_in_mongolia;
	$container_id= 	$row ->container;
	
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
	$item_status = $row->status;
	$container_description= 	$row ->container_description;

	//$proxy_type = $row->proxy_type;
	$package_array =$row->package;
	if ($package_array!="")
	{
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
	}


	if ($container_id!=0)
		{
		$query_container = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
		$row_container = $query_container->row();
		$name= 	$row_container ->name;
		$created= 	$row_container ->created;
		$departed= 	$row_container ->departed;
		$expected= 	$row_container ->expected;
		$description_container= 	$row_container ->description;
		$status= 	$row_container ->status;
		echo "<b>".$name."</b><br>";
		echo "Үүсгэсэн огноо:".$created."<br>";
		echo "Төлөв:".$status."<br>";
		echo "Америкаас гарсан огноо:".$departed."<br>";
		echo "Монголд очих огноо:".$expected."<br>";
		echo "<p>".$description_container."</p>";
		}


	echo "<table class='table table-hover'>";		
	echo "<tr><td>Хэрэглэгчийн тайлбар</td><td>".$container_description."</td></tr>";
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
	//if ($proxy!=0) echo "<tr><td>Хэн авах</td><td>".proxy2($proxy,$proxy_type,"name")."</td></tr>" ;
	if ($item_status=='delivered')
	echo "<tr><td>Гардан авсан (огноо)</td><td>".customer($deliver,"full_name")." (".$delivered_date.")</td></tr>";
	if ($item_status=='new')
		{
			echo "<tr><td>Төлсөн</td><td>".$payment."кг</td></tr>";
			echo "<tr><td>Монголд төлөх</td><td>".$pay_in_mongolia."кг</td></tr>";
		}
	if ($item_status=='weight_missing')
	echo "<tr><td>Төлөв</td><td>Америкт хүргэгдээгүй</td></tr>";



	echo "<tr><td>Чингэлэг</td><td>";
		if ($container==0)  echo "Одоогоор чингэлэгт ороогүй байна";
		if ($container!=0) 
			{
				$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
				$row = $query->row();
				echo $row->name." ирэх хугацаа: ".$row->expected;
			}
	echo "</td></tr>";
	if (isset($package1_name) && $package1_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package1_name ($package1_num) - $package1_price $</td></tr>";
	if (isset($package2_name) && $package2_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package2_name ($package2_num) - $package2_price $</td></tr>";
	if (isset($package3_name) && $package3_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package3_name ($package3_num) - $package3_price $</td></tr>";
	if (isset($package4_name) && $package4_name!="")
	echo "<tr><td>Барааны тайлбар (тоо ширхэг)</td><td>$package4_name ($package4_num) - $package4_price $</td></tr>";

	if ($description!="") echo "<tr><td>Нэмэлт тайлбар</td><td>$description</td></tr>";

	echo "<tr><td>Төлөв</td><td>".status_comfort($status)."</td></tr>";
	echo "</table>";

	if ($item_status=="new")
	{
		echo anchor("agents/container_cp72/".$item_id,"CP72 хэвлэх",array('target'=>"new","class"=>"btn btn-primary"));
		echo anchor("agents/container_item_print/".$item_id,"Пайз хэвлэх",array('target'=>"new","class"=>"btn btn-warning"));
	}

	if ($item_status=='weight_missing')
	echo anchor("agents/container_item_price/".$item_id,"Үнэ оруулах",array("class"=>"btn btn-success"))."<br>";


	if ($status=='weight_missing')
	echo anchor("agents/container_item_delete/".$item_id,"Устгах",array("class"=>"btn btn-danger btn-xs"));
	echo "&nbsp;";
	if ($status=='weight_missing')
	echo anchor("agents/container_item_edit/".$item_id,"Засах",array("class"=>"btn btn-warning btn-xs"));
	

}
else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';




?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->