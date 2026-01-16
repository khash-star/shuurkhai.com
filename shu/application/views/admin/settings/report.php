<div class="panel panel-primary">
  <div class="panel-heading">Оnair тооцоо гаргах</div>
  <div class="panel-body">

<? 
$xls_name = date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$grand_total = 0;
$sql = "SELECT orders.* ,customer.name FROM orders LEFT JOIN customer ON orders.receiver=customer.customer_id  WHERE (orders.status='onair' OR orders.status='warehouse') AND (orders.is_online=1 OR (orders.is_online=0 AND orders.advance=1))  GROUP BY receiver ORDER BY name";
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	    echo "<th>№</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Ширхэг</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_price=0;$total_payment=0;
	   $data = array(array('№','Х/авагч','Утас','Barcode','Ширхэг','Жин','Төлбөр'));
		foreach ($query->result() as $row)
			{  
			$receiver = $row->receiver;
			$customer_name=customer ($receiver,"name");
			$customer_tel=customer ($receiver,"tel");
			
			$barcodes_array =array();
			$weight=0;
			$weight_noooo=0;
			$advance=0;
			$admin=0;
			$price=0;
			$sql = "SELECT * FROM orders WHERE (status='onair' OR status='warehouse') AND receiver='$receiver'";
			$query_detail = $this->db->query($sql);
			
			foreach ($query_detail->result() as $row_detail)
				{  
				array_push ($barcodes_array, $row_detail->barcode);
				if ($row_detail->is_online == 0)
					{
					$advance+=$row_detail->advance_value;
					$weight_noooo +=$row_detail->weight;
					}
				if ($row_detail->is_online == 1)
					{
					$admin+=$row_detail->admin_value;
					$weight+=$row_detail->weight;
					}
				}
			$total_payment = $advance+$admin+cfg_price($weight);
			
		if ($total_payment>0)
			{
		   echo "<tr>";
		   echo "<td>".$count."</td>"; 
		   echo "<td>".$customer_name."</td>"; 
		   echo "<td>".$customer_tel."</td>"; 
		   echo "<td>".implode(", ",$barcodes_array)."</td>"; 
		   echo "<td>".count($barcodes_array)."</td>"; 
		   echo "<td>";
		   echo $weight_noooo + $weight;
		   echo "</td>";
		   echo "<td>".$total_payment."</td>";
		   echo "</tr>";
		   $grand_total +=$total_payment;
		    array_push($data,array($count,$customer_name,$customer_tel,implode(", ",$barcodes_array),count($barcodes_array),$weight_noooo + $weight,$total_payment));	
			$count++;
			}

	    
	
		} 
	 echo "<tr><td colspan='6'>Нийт</td><td>$grand_total</td></tr>";
	 echo "</table>";
	 array_push($data,array('Нийт','','','','','',$grand_total));

	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	echo anchor (base_url().'assets/'.$xls_name,"XLSX файл татах",array("class"=>"btn btn-warning"));
}
else echo "Илгээмж олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->