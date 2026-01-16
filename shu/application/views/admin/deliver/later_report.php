<div class="panel panel-primary">
  <div class="panel-heading">Дараа тооцооны тайлан</div>
  <div class="panel-body">
<?
	$xls_name = "transaction.xlsx";
	$total_final =0;
	require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
			

			$data = array(
    		array('Огноо','Харилцагч','Утас','Төлбөр','Үлдэгдэл','Тайлбар'));

			$query_records = $this->db->query("
				SELECT later_payment.* 
				FROM `later_payment`, 
			(SELECT d_customer,MAX(id) max_id FROM `later_payment` GROUP BY d_customer) as `latest` 
				WHERE later_payment.d_customer= latest.d_customer 
					AND later_payment.id= latest.max_id
					AND later_payment.final_balance>0");
			if ($query_records->num_rows() > 0)
				{
					echo "<table class='table table-hover table-bordered'>";
						echo "<tr>";
						echo "<th width='16%'>Огноо</th>"; 
						echo "<th width='17%'>Харилцагч</th>"; 
						echo "<th width='16%'>Утас</th>"; 
						echo "<th width='16%'>Төлсөн</th>"; 
					   	echo "<th width='16%'>Үлдэгдэл</th>"; 
					   	echo "<th width='16%'>Тайлбар</th>"; 
					   	echo "</tr>";
					   	$total_dept=$total_payment=0;
					foreach ($query_records->result() as $row)
					{
						echo "<tr>";
						echo "<td>".$row->date."</td>"; 
						echo "<td>".customer($row->d_customer,"name")."</td>"; 
						echo "<td>".customer($row->d_customer,"tel")."</td>"; 
						echo "<td>".$row->payment."</td>"; 
					   	echo "<td>".$row->final_balance."</td>"; 
					   	echo "<td>".$row->description."</td>"; 
					   	echo "</tr>";

					   	array_push($data,array($row->date,customer($row->d_customer,"name"),customer($row->d_customer,"tel"),$row->payment,$row->final_balance,$row->description));
					   	$total_final+=$row->final_balance;						 
					}

					echo "<tr>";
						echo "<td colspan='4'>Нийт</td>"; 
						echo "<td>".$total_final."</td>"; 
					   	echo "<td></td>"; 
					   	echo "</tr>";
					echo "</table>";
				}
					array_push($data,array("Нийт","","","",$total_final));
				
	  	  	$writer = new XLSXWriter();
			$writer->writeSheet($data);
			$writer->writeToFile('assets/xlsx/'.$xls_name);
			echo anchor(base_url().'assets/xlsx/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));

?>


</div>
</div>