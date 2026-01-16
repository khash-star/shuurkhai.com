<style>
#table td{padding:3px 1px 3px 0px;}
th,td  { max-width:150px !important; overflow:auto;}
</style>
<? 
//$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

echo '<div class="panel panel-primary">';
echo '<div class="panel-heading">Track</div>';
echo '<div class="panel-body">';
//$query = $this->db->query($sql);
//$query = $this->db->like("barcode","CP87");
$track= $_POST["search"];

$order_id = tracksearch($track);

			if ($order_id!="")
			{
				$query = $this->db->query("SELECT * FROM orders WHERE order_id = '$order_id'");
				$row = $query->row();
				

				$third_party=$row->third_party;
				$receiver_id=$row->receiver;
				$created_date=$row->created_date;
				$status=$row->status;
				$agent_id=$this->session->userdata("agent_id");
				


			
	// echo form_open("agents/tracks_changing");
     echo "<table class='table table-hover small' id='table'>";
	 echo "<tr>";
	  // echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   //echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th class='track_td'>Barcode / Track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 

	   echo "<th>Жин</th>";
	   echo "<th>Үлдэгдэл</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   //$count=1;$total_weight=0;$total_price=0;
	   /*$data = array(
    array('Хүлээн авагч','','','','','Barcode','Track№','Төлөв','Жин','Үлдэгдэл','Тайлбар'),
	array('Нэр','Овог','РД','Утас','Хаяг'));
	foreach ($query->result() as $row)
	{  */
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
		$receiver_surname=customer($receiver_id,"surname");
		$receiver_contact=customer($receiver_id,"contact");
		$receiver_address=customer($receiver_id,"address");
		$receiver_name=customer($receiver_id,"name");		
		$receiver_rd=customer($receiver_id,"rd");
		$proxy=$row->proxy_id;
		$proxy_type=$row->proxy_type;
		$barcode=$row->barcode;
		$description=$row->package;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$third_party = $row->third_party;
		$extra=$row->extra;
		$transport=$row->transport;
		$status=$row->status;
		//$total_weight+=$weight;
		//$total_price+=$Package_advance_value;
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
		if ($receiver_id!="" &&$status=='order'&&!$tr)
		{echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
		
		if ($receiver_id!=1&&$status=='filled'&&!$tr)
		{echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
		
		
	  	if ($Package_advance==1&&!$tr)
		{echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
		
		if ($status=='weight_missing'&&!$tr)
		{echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1;}
		
		if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
		if (!$tr) echo "<tr>";else $tr=0;
	   //echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date;
	if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

	   echo "</td>"; 
	   	echo "<td>".anchor("admin/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver_name);
		echo "<br>".proxy2($proxy,$proxy_type,"name")."</td>";

	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
	   if ($third_party!="")
	echo "<a href='".track($third_party)."' target='new' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
	   echo "</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$weight."</td>"; 
	   echo "<td>".$Package_advance_value."</td>"; 
	   //echo "<td>".anchor('agents/tracks_detail/'.$row->order_id,'<img src="'.base_url().'assets/more.png" class="more" title="дэлгэрэнгүй">')."</td>"; 
	   echo "<td>".anchor('agents/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
 /*array_push($data,array($receiver,$receiver_surname,$receiver_rd,$receiver_contact,$receiver_address,$barcode,"  ".strval($third_party),$temp_status,floatval($weight),floatval($Package_advance_value),$description));

	} 
	 echo "<tr><td colspan='7'>Нийт ($total_weight Кг) $total_price</td></tr>";
	 array_push($data,array('Нийт','','','','','','','',floatval($total_weight),floatval($total_price),$description));
	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);*/
	echo "</table>";
	//echo "<br><br><br><br>".anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'button'));

}
else 
{
	$track = strtolower($track);

	$sql="SELECT orders.*,customer.name,customer.tel FROM orders, customer WHERE orders.receiver=customer.customer_id AND ";

	$sql.=" LOWER(CONVERT(CONCAT_WS(barcode,package,customer.name,customer.tel,third_party)USING utf8)) LIKE '%".$track."%' ORDER BY created_date DESC"; 

     $query = $this->db->query($sql);
$payment_rate = cfg_paymentrate();
//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
	{
	    echo "<table class='table table-striped small' id='table_dd'>";
			echo "<thead>";
			echo "<tr>";
			   echo "<th>№</th>"; 
			   echo "<th>Үүсгэсэн огноо</th>"; 
			   echo "<th>Хүлээн авагч</th>"; 
			   echo "<th>Утас</th>"; 
			   echo "<th>Barcode / Track</th>"; 
			   echo "<th>Хоног</th>"; 
			   echo "<th>Төлөв</th>"; 
			   echo "<th>Жин</th>";
			   echo "<th></th>"; 
			   echo "</tr>";
			echo "</thead>";

		   	echo "<tbody>";
		   	$count=1;$total_weight=0;$total_price=0;
			foreach ($query->result() as $row)
			{  
				$created_date=$row->created_date;
				$order_id=$row->order_id;
				$weight=$row->weight;
				$price=$row->price;
		   		
				$receiver_id=$row->receiver;
				$proxy=$row->proxy_id;
				$proxy_type=$row->proxy_type;

				$receiver=customer($receiver_id,"name");
				$receiver_surname=customer($receiver_id,"surname");
				$receiver_contact=customer($receiver_id,"tel");
				$receiver_address=customer($receiver_id,"address");
				$receiver_rd=customer($receiver_id,"rd");

				$barcode=$row->barcode;
				$description=$row->package;
				$Package_advance = $row->advance;
				$Package_advance_value = $row->advance_value;
				$third_party = $row->third_party;
				$extra=$row->extra;
				$print=$row->print;
				$status=$row->status;
				$total_weight+=intval($weight);
				$total_price+=intval($Package_advance_value);
				$tr=0;
				$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
				if ($receiver_id!="" &&$status=='order'&&!$tr)
					{echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1; $class="blue";}
				
				if ($receiver_id!=1&&$status=='filled'&&!$tr)
					{echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;$class="green";}
				
				
			  	if ($Package_advance==1&&!$tr)
					{echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1; $class="red";}
				
				if ($status=='weight_missing'&&!$tr)
					{echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="yellow";}
				
				if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
				if (!$tr) echo "<tr>";else $tr=0;
			   	echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
			   	echo "<td  class='$class'>".$created_date."</td>"; 
				echo "<td class='$class'>".anchor("agents/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver).count_new_receiver($receiver_id)."<br>".proxy2($proxy,$proxy_type,"name")."</td>";

			   	echo "<td  class='$class'>".$receiver_contact."</td>"; 
			   	echo "<td  class='$class'>".$barcode."<br>"; 
			   	if ($third_party!="")
					echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
			   echo "</td>"; 
			   echo "<td  class='$class'>".$days."</td>"; 
			   echo "<td  class='$class'>".$temp_status."</td>";
			   echo "<td  class='$class'>"; echo $weight;if($weight>0) "Kg";echo "</td>"; 
			  // echo "<td  class='$class'>".cfg_price($weight)."$</td>"; 
			   //echo "<td>".anchor('agents/tracks_detail/'.$row->order_id,'<img src="'.base_url().'assets/more.png" class="more" title="дэлгэрэнгүй">')."</td>"; 
			   echo "<td  class='$class' id='$class'>";
			   if ($print==0&&$status=="new") 
			   echo anchor('agents/tracks_preview/'.$row->order_id,'<span class="glyphicon glyphicon-print"></span>',array("title"=>"CP72 хэвлэх","target"=>"_blank"));
			   if ($status=="filled") 
			   echo anchor('agents/tracks_preview/'.$row->order_id,'<span class="glyphicon glyphicon-print"></span>',array("title"=>"CP72 хэвлэх"));
			   echo anchor('agents/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>');
			   "</td>"; 
			   echo "</tr>";
			   $class="";
			} 
		echo "</tbody>";
		echo "</table>";
	}
	}

echo '</div>';
echo '</div>';
?>


<script type="text/javascript" src="<?=base_url();?>assets/js/tooltip.js"></script>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>