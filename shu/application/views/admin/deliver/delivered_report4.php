<div class="panel panel-primary">
  <div class="panel-heading">Гардуулалтын тайлан /Бэлэн/</div>
  <div class="panel-body">

<? 
$sql = "SELECT * FROM bills";
$query = $this->db->query($sql);
/*if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{  
				$bill_id = $row->id;
				$barcode = $row->barcode;
				$barcodes_array =explode(',',$barcode);
				$shirheg = count($barcodes_array);
				$sql = "UPDATE bills SET count=$shirheg WHERE id=$bill_id";
				$query = $this->db->query($sql);
			}
		}
	*/
// $xls_name = date("ymd").rand(0,10000).".xlsx";
$xls_name = "report4.xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$grand_total = 0;

$total_account = 0;
$total_pos = 0;
$total_cash = 0;
$total_later = 0;
$total_weight = 0;


if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -3 days'))." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


$sql = "SELECT * FROM (
SELECT id,timestamp,deliver,barcode,weight,count,cash,account,pos,later,total FROM `bills` 
UNION
SELECT id,timestamp,deliver,barcode,weight,count,cash,account,pos,later,total FROM `bills_container` )  a
WHERE timestamp>='$start_date' AND timestamp<='$finish_date'";



//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	    echo "<th>№</th>"; 
	   echo "<th>Гардагч</th>"; 
	   echo "<th>Утас</th>"; 
	   //echo "<th>Barcode</th>"; 
	   
	   echo "<th>Жин</th>"; 
	   echo "<th>Тоо</th>"; 
	   echo "<th>Данс</th>"; 
	   echo "<th>Пос</th>"; 
	   echo "<th>Бэлэн</th>"; 
	   echo "<th>Дараа тооцоо</th>"; 
	   echo "<th>Нийт</th>"; 
	   
	   echo "</tr>";
	  $total_weight=0;$total_count=0;
	   $data = array(array('№','Огноо','Х/авагч','Утас','Баркод','Жин','Тоо','Данс','Пос','Бэлэн','Дараа тооцоо','Нийт'));
		foreach ($query->result() as $row)
			{  
			$deliver = $row->deliver;
			$customer_name=customer ($deliver,"name");
			$customer_tel=customer ($deliver,"tel");
			$barcodes_array = $row->barcode;
			$barcode = $row->barcode;
			$barcodes_array =explode(',',$barcode);
			$shirheg = count($barcodes_array);

			$bill_id=$row->id;
			$weight=$row->weight;
			$count=$row->count;
			$account  = floatval($row->account);
			$pos  = floatval($row->pos);			
			$cash  = floatval($row->cash);			
			$later  = floatval($row->later);			
			$total  = floatval($row->total);		
			$timestamp  = $row->timestamp;		


		   echo "<tr>";
		   echo "<td>".$bill_id."</td>"; 
		   echo "<td>".$customer_name."</td>"; 
		   echo "<td>".$customer_tel."</td>"; 
		   //echo "<td>".$barcodes_array."</td>"; 
		   echo "<td>".$weight."</td>"; 
		   echo "<td>".$count."</td>"; 
		   echo "<td align='right'>".number_format($account)."</td>"; 
		   echo "<td align='right'>".number_format($pos)."</td>"; 
		   echo "<td align='right'>".number_format($cash)."</td>"; 
		   echo "<td align='right'>".number_format($later)."</td>"; 
		   echo "<td align='right'>".number_format($total)."</td>";
		   echo "</tr>";
		   $grand_total +=$total;
		   $total_count +=$count;
		   $total_account +=$account;
		   $total_pos +=$pos;
		   $total_cash +=$cash;
		   $total_later +=$later;
		   $total_weight +=$weight;

		    array_push($data,array($bill_id,$timestamp,$customer_name,$customer_tel,$barcode,floatval($weight),floatval($count),floatval($account),floatval($pos),floatval($cash),floatval($later),floatval($total)));	
		} 
		 echo "<tr><td colspan='3'>Нийт</td><td>$total_weight</td><td>$total_count</td><td align='right'>".number_format($total_account)."</td><td align='right'>".number_format($total_pos)."</td><td align='right'>".number_format($total_cash)."</td><td align='right'>".number_format($total_later)."</td><td align='right'>".number_format($grand_total)."</td></tr>";
		 echo "</table>";
		 array_push($data,array('Нийт','','','','',floatval($total_weight),floatval($total_count),floatval($total_account),floatval($total_pos),floatval($total_cash),floatval($total_later),$grand_total));

		$writer = new XLSXWriter();
		$writer->writeSheet($data);
		$writer->writeToFile('assets/'.$xls_name);
		echo anchor (base_url().'assets/'.$xls_name,"XLSX файл татах",array("class"=>"btn btn-warning"));
	}
else echo "Илгээмж олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->