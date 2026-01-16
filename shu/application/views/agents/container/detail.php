<? if (!$this->uri->segment(3)) redirect('agents/container'); else $container_id=$this->uri->segment(3) ?>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг дэлгэрэнгүй мэдээлэл</div>
  <div class="panel-body">
<? 
$xls_name = "container".$container_id.date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$name= 	$row ->name;
	$created= 	$row ->created;
	$departed= 	$row ->departed;
	$expected= 	$row ->expected;
	$description= 	$row ->description;
	$status= 	$row ->status;
	echo "<h1>".$name; echo anchor("agents/container_edit/".$container_id,"засах",array("class"=>"btn btn-success btn-xs"));echo "</h1>";
	if ($status=="new") echo anchor("agents/container_fill/".$container_id,"Ачаа оруулах",array("class"=>"btn btn-warning"))."<br>";
	echo "Үүсгэсэн огноо:".$created."<br>";
	echo "Төлөв:".$status."<br>";
	echo "Америкаас гарсан огноо:".$departed."<br>";
	echo "Монголд очих огноо:".$expected."<br>";
	echo "<p>".$description."</p>";

	$data = array(array('Чингэлэгийн дугаар',$name."(".$expected.")",'','','','','','','','',''));

}
echo "<b>Чингэлэг лог</b><br>";
$query=$this->db->query("SELECT * FROM container_log WHERE container='".$container_id."' ORDER BY date DESC");
if ($query->num_rows() > 0)
{	 
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
	  	echo "<th>Огноо</th>"; 
		echo "<th>Тайлбар</th>";
		echo "<th>Үйлдэл</th>"; 
	  	echo "</tr>";
	 	$count=1;
		foreach ($query->result() as $row)
			{ 
		   $date=$row->date;
		   $description=$row->description;
		  
		   echo "<tr>";
		   echo "<td>".$count++."</td>";
		   echo "<td>".$date."</td>";
		   echo "<td>".$description."</td>";
		   echo "<td>";
		   echo anchor("agents/container_log_edit/".$container_id,"Засах");
			//echo anchor("agents/container_log_delete/".$container_id,"устгах",array("class"=>"btn btn-alert btn-xs"));

		   echo "</td>";
		   echo "</tr>";
		}
    echo "</table>";
}
   else echo "No log";

   echo "<hr>";

	echo "<b>Доторхи ачаа</b><br>";

   $query=$this->db->query("SELECT * FROM container_item WHERE container='".$container_id."'");
if ($query->num_rows() > 0)
{	 	
		$total_weight=$total_payment=$total_pay_in_mongolia=$grandtotalprice=0;
	 	array_push($data,array('Barcode','Илгээгч','Илгээгч дугаар','Хүлээн авагч','Х/а дугаар','Тайлбар','Барааны тайлбар','Барааны үнэ','Хэмжээ','Төлбөр','Монголд Тооцоо'));

		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
		echo "<th>Barcode / Тайлбар</th>"; 
	  	echo "<th>Илгээгч/ Хүлээн авагч</th>";
		echo "<th>Хэмжээ</th>";
		echo "<th>Төлбөр</th>";
		echo "<th>Монголд Тооцоо</th>"; 
		echo "<th></th>"; 
	  	echo "</tr>";
	 	$count=1;
		foreach ($query->result() as $row)
			{
			   $item=$row->id; 
			   $sender=$row->sender;
			   $receiver=$row->receiver;
			   $description=$row->description;
			   $barcode=$row->barcode;
			   $weight=$row->weight;
			   $payment=$row->payment;
			   $pay_in_mongolia=$row->pay_in_mongolia;
			   $package=$row->package;
			   $total_weight+=floatval($weight);
			   $total_payment+=$payment;
			   $total_pay_in_mongolia+=$pay_in_mongolia;

			   $package_array=explode("##",$package);
			   $package1_name = $package_array[0];
			   $package1_num = $package_array[1];
			   $package1_price = intval($package_array[2]);
			   $package2_name = $package_array[3];
			   $package2_num = $package_array[4];
			   $package2_price = intval($package_array[5]);
			   $package3_name = $package_array[6];
			   $package3_num = $package_array[7];
			   $package3_price = intval($package_array[8]);
			   $package4_name = $package_array[9];
			   $package4_num = $package_array[10];
			   $package4_price = intval($package_array[11]);			

			   $product_detail ="";
			   $price =0;
			   if ($package1_name!="")
			    {
					$product_detail.=$package1_name;
					$price+=$package1_price;
				}
			   if ($package2_name!="")
			   {
			    $product_detail.="/".$package2_name;
				$price+=$package2_price;
			   }
			   if ($package3_name!="")
			   {
			    $product_detail.="/".$package3_name;
				$price+=$package3_price;
			   }
			   if ($package4_name!="")
			   {
			   $product_detail.="/".$package4_name;
			   $price+=$package4_price;
			   }
			   
			   $grandtotalprice +=$price;

			   

			   echo "<tr>";
			   echo "<td>".$count++."</td>";
			   echo "<td>".anchor("agents/container_item_detail/".$item,$barcode)."<br>".$description.$product_detail."</td>";
			   echo "<td>".anchor("agents/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."<br>".anchor("agents/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."</td>";
			    echo "<td>".$weight."</td>";
			    echo "<td>".$payment."$</td>";
			    echo "<td>".$pay_in_mongolia."$</td>";
			   echo "<td>";
			    echo anchor("agents/container_item_edit/".$item,"Засах")."<br>";
				echo anchor("agents/container_item_out/".$item,"Гаргах");

			   echo "</td>";
			   echo "</tr>";
			   array_push($data,array($barcode,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"),customer($sender,"tel"),substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"),customer($receiver,"tel"),$description,$product_detail,$price,$weight,$payment,$pay_in_mongolia));
			}

			    echo "<tr>";
			    echo "<td colspan='3'>Нийт</td>";
				echo "<td>".$total_weight."Kg</td>";
			    echo "<td>".$total_payment."$</td>";
			    echo "<td>".$total_pay_in_mongolia."$</td>";
			    echo "<td></td>";
			    echo "</tr>";
			    array_push($data,array('Нийт','','','','','','',$grandtotalprice,$total_weight,$total_payment,$total_pay_in_mongolia));
				$writer = new XLSXWriter();
				$writer->writeSheet($data);
				$writer->writeToFile('assets/xlsx/'.$xls_name);
				echo "</table>";
			echo "".anchor(base_url().'assets/xlsx/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));
}
   else echo "No log";




?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->