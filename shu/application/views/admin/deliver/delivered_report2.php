<div class="panel panel-primary">
  <div class="panel-heading">Гардуулсан ачааны тооцоо гаргах</div>
  <div class="panel-body">

<? 
$xls_name = date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$grand_total = 0;
if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';

if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


$sql = "SELECT * FROM bills WHERE timestamp>'$start_date' AND timestamp<'$finish_date'";

if ($method_type!="all") $sql.=" AND type ='$method_type'";

//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	    echo "<th>№</th>"; 
	   echo "<th>Хугацаа</th>"; 
	   echo "<th>Нэр</th>"; 
	   echo "<th width='100px' style='overflow:hidden !important'>Barcode</th>"; 
	   echo "<th>Ширхэг</th>"; 
	   echo "<th>Жин</th>"; 	   
	   echo "<th>Бэлэн</th>"; 
	   echo "<th>POS</th>";
	   echo "<th>Дансаар</th>";
	   echo "<th>Дараа тооцоо</th>"; 
	   echo "<th>Нийт</th>"; 
	   echo "<th>Тулгалт</th>"; 
	   echo "</tr>";
	   $count=1;$total_cash=0;$total_pos=0;$total_account=0;$total_later=0;$total_total=0;$total_shirheg=0;$total_weight=0;
	   $data = array(array('№','Хугацаа','Х/авагч','Утас','Barcode','Ширхэг','Жин','Бэлэн','POS','Дансаар','Дараа тооцоо','Нийт','Тулгалт'));
		foreach ($query->result() as $row)
			{  
			$deliver = $row->deliver;
			$bill_id = $row->id;
			$customer_name=customer ($deliver,"name");
			$customer_tel=customer ($deliver,"tel");
			$barcode = $row->barcode;
			$barcodes_array =explode(',',$barcode);
			$weight = $row->weight;
			$cash=$row->cash;
			$pos=$row->pos;
			$account=$row->account;
			$later=$row->later;
			$total=$row->total;
			$timestamp=$row->timestamp;
			$shirheg = count($barcodes_array);
			$weight_tulgalt = $weight;

			if ($weight!=0) $tulgalt = cfg_price($weight_tulgalt)*cfg_rate(); 
				{
					foreach($barcodes_array as $barcode_single)
					{
						$weight_tulgalt+=barcode_search($barcode_single,"weight");
					}
					$tulgalt = cfg_price($weight_tulgalt)*cfg_rate(); 
				}

		   echo "<tr>";
		   echo "<td>".$bill_id."</td>"; 
		   echo "<td>".$timestamp."</td>"; 
		   echo "<td>".$customer_name."</td>"; 
		   echo "<td width='100px' style='overflow:hidden'>".implode(", ", $barcodes_array)."</td>"; 
		   
		   echo "<td>".$shirheg."</td>"; 
		   echo "<td>".$weight."</td>"; 
		   echo "<td>".number_format(floatval($cash))."</td>";
		   echo "<td>".number_format(floatval($pos))."</td>";
		   echo "<td>".number_format(floatval($account))."</td>";
		   echo "<td>".number_format(floatval($later))."</td>";
		   echo "<td>".number_format(floatval($total))."</td>";
		   echo "<td>".number_format(floatval($tulgalt))."</td>";
		   echo "</tr>";
		   $total_cash+=floatval($cash);$total_pos+=floatval($pos);$total_account+=floatval($account);$total_later+=floatval($later);$total_total+=$total;$total_shirheg+=$shirheg;$total_weight+=$weight;
		    array_push($data,array($count,$timestamp,$customer_name,$customer_tel,$barcode,$shirheg,floatval($weight),floatval($cash),floatval($pos),floatval($account),floatval($later),floatval($total),floatval($tulgalt)));	
		    $count++;
			} 
	 echo "<tr><td colspan='4'>Нийт</td><td>".number_format($total_shirheg)."</td><td>".number_format($total_weight)."</td><td>".number_format($total_cash)."</td><td>".number_format($total_pos)."</td><td>".number_format($total_account)."</td><td>".number_format($total_later)."</td><td>".number_format($total_total)."</td><td></td></tr>";
	 echo "</table>";
	 array_push($data,array('Нийт','','','','',$total_shirheg,$total_weight,$total_cash,$total_pos,$total_account,$total_later,$total_total,''));

	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	echo anchor (base_url().'assets/'.$xls_name,"XLSX файл татах",array("class"=>"btn btn-warning"));
}
else echo "Олголт олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->