<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгт ороогүй ачаа</div>
  <div class="panel-body">
  <?

   $query=$this->db->query("SELECT * FROM container_item WHERE container=0 ORDER BY id DESC");
	if ($query->num_rows() > 0)
		{	 
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
		echo "<th>Barcode / Тайлбар</th>"; 
	  	echo "<th>Илгээгч/ Хүлээн авагч</th>";
		echo "<th>Жин</th>";
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
		  
		   echo "<tr>";
				echo "<td>".$count++."</td>";
				echo "<td>".anchor("agents/container_item_detail/".$item,$barcode)."<br>".$description."</td>";
				echo "<td>".anchor("agents/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."<br>".anchor("agents/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."</td>";
				echo "<td>".$weight."</td>";
				echo "<td>".$payment."$</td>";
				echo "<td>".$pay_in_mongolia."$</td>";
				echo "<td>";
				echo "</td>";
		   echo "</tr>";
		}
    echo "</table>";
	} 
	?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->