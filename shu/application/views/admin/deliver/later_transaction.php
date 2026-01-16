<div class="panel panel-primary">
  <div class="panel-heading">Дараа тооцоо тулгалт</div>
  <div class="panel-body">
<?
	$xls_name = "transaction.xlsx";
	require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
	if (isset($_POST["contacts"]))
	{
		$contacts = $_POST["contacts"];
		$start_date = $_POST["start_date"];
		$finish_date = $_POST["finish_date"];
		$query = $this->db->query("SELECT * FROM customer WHERE tel='".$contacts."' LIMIT 1");
		if ($query->num_rows() == 1)
		{

			$row = $query->row();
			$customer_id = $row ->customer_id;
			$init_balance=0;
			echo "<h4>".customer($customer_id,"full_name")."</h4>";
			echo "<p>(".$start_date." - ".$finish_date.")</p>";

			$query_records = $this->db->query("SELECT * FROM later_payment WHERE d_customer='".$customer_id."' LIMIT 1");
			if ($query_records->num_rows() ==1)
			{
				$row = $query_records->row();
				$init_balance = $row->init_balance;
				echo "<span class='pull-right'> Эхний үлдэгдэл ".$init_balance."</span>";
			}
			$data = array(
    		array('Харилцагч','','','','('.$start_date.' - '.$finish_date.')'),
    		array(customer($customer_id,"full_name"),'','','',$init_balance));
			$query_records = $this->db->query("SELECT * FROM later_payment WHERE d_customer='".$customer_id."'");
			if ($query_records->num_rows() > 0)
				{
					echo "<table class='table table-hover table-bordered'>";
						echo "<tr>";
						echo "<th width='30%'>Огноо</th>"; 
						echo "<th width='10%'>Кр</th>"; 
					   	echo "<th width='10%'>Дп</th>"; 
					   	echo "<th width='20%'>Үлдэгдэл</th>"; 
					   	echo "<th width='50%'>Тайлбар</th>"; 
					   	echo "</tr>";
					   	$total_dept=$total_payment=0;
					foreach ($query_records->result() as $row)
					{
						echo "<tr>";
						echo "<td>".$row->date."</td>"; 
						echo "<td>".customer($row->d_customer,"name")."</td>"; 
						echo "<td>".$row->dept."</td>"; 
					   	echo "<td>".$row->payment."</td>"; 
					   	echo "<td>".$row->final_balance."</td>"; 
					   	echo "<td>".$row->description."</td>"; 
					   	echo "</tr>";

					   	array_push($data,array($row->date,$row->dept,$row->payment,$row->final_balance,$row->description));
					   	$total_dept+=$row->dept; $total_payment+=$row->payment;
						 
					}

					echo "<tr>";
						echo "<td>Нийт</td>"; 
						echo "<td>".customer($row->d_customer,"name")."</td>";
						echo "<td>".$total_dept."</td>"; 
					   	echo "<td>".$total_payment."</td>"; 
					   	echo "<td></td>"; 
					   	echo "<td></td>"; 
					   	echo "</tr>";
					echo "</table>";
					array_push($data,array("Нийт",$total_dept,$total_payment));
				}
	  	 		else echo "Бичиглэл олдсонгүй<br>";
	  	  	$writer = new XLSXWriter();
			$writer->writeSheet($data);
			$writer->writeToFile('assets/'.$xls_name);
			echo anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));


		}
		else echo "Хэрэглэгчийн мэдээлэл олдсонгүй";	
	}	

?>


</div>
</div>