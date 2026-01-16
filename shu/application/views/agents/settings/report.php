<div class="panel panel-primary">
  <div class="panel-heading">Тооцоо тайлан</div>
  <div class="panel-body">

<? 
$xls_name = date("ymd").rand(0,10000).".xlsx";
$grand_total = 0;
$sql = "SELECT orders.* ,count(order_id) as Count, sum(weight) as total FROM orders  WHERE status not IN('new','order','weight_missing') AND onair_date!='0000-00-00 00:00:00' GROUP BY onair_date ORDER BY onair_date DESC";
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
		{
		echo "<table class='table table-hover small'>";
		echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	    echo "<th>№</th>"; 
	   echo "<th>Onair</th>"; 
	   echo "<th>Тоо ширхэг</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "</tr>";
	   $count=1;
		foreach ($query->result() as $row)
			{  
			$weight = $row->total;
			$onair_date = $row->onair_date;
			$count_order = $row->Count;

		   echo "<tr>";
		   echo "<td>".$count."</td>"; 
		   echo "<td>".$onair_date."</td>"; 
		   echo "<td>".$count_order."</td>"; 
		   echo "<td>".number_format($weight,2)."</td>"; 
		   echo "<td>".cfg_price($weight)."$</td>"; 
		   echo "</tr>";
			$count++;
			} 
	
		} 
	 echo "</table>";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->