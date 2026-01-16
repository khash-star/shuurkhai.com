<div class="panel panel-primary">
  <div class="panel-heading">Гардуулалтын тайлан /Дараа тооцоо/</div>
  <div class="panel-body">

<? 
//$xls_name = date("ymd").rand(0,10000).".xlsx";
$xls_name = "report3.xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$grand_total = 0;
if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';

if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


$sql = "SELECT * FROM orders WHERE (status='delivered' OR status='custom')";

$sql.=" AND orders.method ='later'";
if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";

$sql.=" GROUP BY deliver";
//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	    echo "<th>№</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Ширхэг</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_payment=$grand_weight=0;
	   $data = array(array('№','Гардагч','Утас','Barcode','Ширхэг','Жин','Төлбөр'));
		foreach ($query->result() as $row)
			{  
			$deliver = $row->deliver;
			$customer_name=customer ($deliver,"name");
			$customer_tel=customer ($deliver,"tel");
			
			$barcodes_array =array();
			$weight=0;
			$weight_noooo=0;
			$advance=0;
			$admin=0;
			$price=0;
			
			$sql = "SELECT * FROM orders WHERE (status='delivered' OR status='custom') AND deliver='$deliver'";
			$sql.=" AND orders.method ='later'";
			if ($start_date!="")  $sql.=" AND delivered_date>='$start_date'";
			if ($finish_date!="")  $sql.=" AND delivered_date<='$finish_date'";

		//	echo "<br>".$sql;
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
				$method=$row->method;
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
		   $total_weight =$weight_noooo + $weight;
		   $grand_weight+=$total_weight;
		   $grand_total +=$total_payment;
		    array_push($data,array($count,$customer_name,$customer_tel,implode(", ",$barcodes_array),count($barcodes_array),$total_weight,$total_payment));	
			$count++;
			}
		$method="";
	    
	
		} 
	 echo "<tr><td colspan='5'>Нийт</td><td>$grand_weight"."кг</td><td>$grand_total"."$</td><td></td></tr>";
	 echo "</table>";
	 array_push($data,array('Нийт','','','','',$grand_weight,$grand_total));

	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	echo anchor (base_url().'assets/'.$xls_name,"XLSX файл татах",array("class"=>"btn btn-warning"));
}
else echo "Илгээмж олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->