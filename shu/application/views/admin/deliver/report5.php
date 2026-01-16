<div class="panel panel-primary">
  <div class="panel-heading">Агуулахын илгээмж</div>
  <div class="panel-body">

<? 
$sql = "SELECT * FROM orders WHERE status='warehouse' ORDER BY deliver";
$query = $this->db->query($sql);

$xls_name = "warehouse.xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$total_weight = 0;
$count=1;

//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	    echo "<th>№</th>"; 
	    echo "<th>Хүлээн авагч</th>"; 
	    echo "<th>Пайзын нэр</th>"; 
	    echo "<th>Пайзын Утас</th>"; 
	   	echo "<th>Barcode</th>"; 
	   	echo "<th>Тавиур</th>"; 
	  	echo "<th>Жин</th>"; 
	   
	   echo "</tr>";
	  		$total_weight=0;$total_count=0;
	   		$data = array(array('№','Х/авагч','Х/утас','Пайз','Утас','Баркод','Тавиур','Жин'));
		foreach ($query->result() as $row)
			{  
				
			$deliver = $row->deliver;
			$barcode = $row->barcode;
			$proxy_type = $row->proxy_type;
			$proxy_id = $row->proxy_id;
			$weight = $row->weight;
			$warehouse_date = $row->warehouse_date;
			$extra = $row->extra;
			$customer_name=customer ($deliver,"name");
			$customer_tel=customer ($deliver,"tel");
			$proxy_name=proxy2($proxy_id,$proxy_type,"name");
			$proxy_tel=proxy2($proxy_id,$proxy_type,"tel");
		
			   echo "<tr>";
			   echo "<td>".$count."</td>"; 
			   echo "<td>".$customer_name."</td>"; 
			   echo "<td>".$proxy_name."</td>"; 
			   echo "<td>".$proxy_tel."</td>"; 
			   echo "<td>".$barcode."</td>"; 
			   echo "<td>".$extra."-р тавиур</td>"; 
			   echo "<td>".$weight."</td>"; 
			   echo "</tr>";

		   $total_weight +=$weight;
		 

		    array_push($data,array($count,$customer_name,$customer_tel,$proxy_name,$proxy_tel,$barcode,$extra."-р тавиур",floatval($weight)));
		    $count++;	
		} 
		 echo "<tr><td colspan='6'>Нийт</td><td>$total_weight</td></tr>";
		 echo "</table>";
		 array_push($data,array('Нийт','','','','','','',floatval($total_weight)));

		$writer = new XLSXWriter();
		$writer->writeSheet($data);
		$writer->writeToFile('assets/'.$xls_name);
		echo anchor (base_url().'assets/'.$xls_name,"XLSX файл татах",array("class"=>"btn btn-warning"));
	}
else echo "Агуулахад бараа алга";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->