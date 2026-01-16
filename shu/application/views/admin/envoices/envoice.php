<style>
.panel {max-width:700px;  margin:auto; margin-top:-50px;}
@media print{    
    .panel{ max-width:70%;font-size:10px; }
	a {display:none !important; height:0px !important; width:0px !important;}
}
</style>
<? 
$customer_id = $this->session->userdata('customer_id');
if ($this->uri->segment(3)) 

	{
	$envoice_id=$this->uri->segment(3);

	$sql = "SELECT * FROM envoice WHERE envoice_id='$envoice_id'";

	$query = $this->db->query($sql);
	if ($query->num_rows() == 1)
	{
	$row = $query->row();
	$orders = explode (",",$row->orders);
	$customer_id = $row->customer_id;
	$amount = $row->amount;

?>


<div class="panel panel-success">
  <div class="panel-heading">Нэхэмжлэх №<?=sprintf("%07d", $envoice_id);?></div>
  <div class="panel-body">
 	
    

<table width="100%">
  <tr><td align="left" width="50%">Нэхэмжлэгч:<br />Shuurkhai Cargo </td>
  
    
    <td align="left">Төлөгч: <br /> <?=customer($customer_id,"full_name");?></td></tr>
    <tr><td align="left" width="50%">Хаяг:<br />4712 OAKTON STREET, Skokie, IL <br /> Zip: 60076</td>
  
    
    <td align="left">Хаяг: <br /> <?=customer($customer_id,"address");?></td></tr>
      
	<tr><td align="left">  Утас:<br />773-621-6807 </td><td> Утас:<br /><?=customer($customer_id,"tel");?></td></tr>
    <tr><td align="left">  Email:<br />info@shuurkhai.com </td><td> Email:<br /><?=customer($customer_id,"email");?></td></tr>
     <tr><td align="left">  Нэхэмжилсэн огноо: <?=date("Y-m-d");?></td><td> </td></tr>
     <tr><td align="left">Банкны нэр: ХХБанк<br />
Банкны дансны нэр: Хашбал 		<br />
Төгрөг:411009565		<br />
Доллар:416002824	<br />	 </td><td></td></tr>
    </table>
    
    

    <div class="clearfix" style="height:50px;"></div>
    
<?

	echo "<table class='table table-stripe'>";
	echo "<tr><th>№</th><th>Баркод</th><th>Барааны нэр (Тоо хэмжээ)</th><th>Жин (Кг)</th></tr>";
	

	$N = count($orders);
	if ($N>0 || $orders!="")
	{	
 	$total_weight=0;
	$count=1;
    for($i=0; $i < $N; $i++)
    {
	$order_id=$orders[$i];
	
	
	$sql = "SELECT * FROM orders WHERE receiver=".$customer_id." AND order_id='".$order_id."'";
	
	$query = $this->db->query($sql);
	
	if ($query->num_rows() ==1)
	{
		$row = $query->row();
		//$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
		
		
		$created_date=$row->created_date;
		$onair_date=$row->onair_date;
		$warehouse_date=$row->warehouse_date;
		$delivered_date=$row->delivered_date;
		
		
		$barcode=$row->barcode;
		$package=$row->package;
		$price=$row->price;
		
		$sender=$row->sender;
		$receiver=$row->receiver;
		$deliver=$row->deliver;
		
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$advance=$row->advance;
		$advance_value=$row->advance_value;
		$third_party=$row->third_party;
		
		$way=$row->way;
		$deliver_time=$row->deliver_time;
		$inside=$row->inside;
		$return_type=$row->return_type;
		$return_day=$row->return_day;
		$return_way=$row->return_way;
		$return_address=$row->return_address;
		
		$extra=$row->extra;
		$timestamp=$row->timestamp;
		$status=$row->status;
		$agents=$row->agents;
		$is_online=$row->is_online;
		
		
		$package_array=explode("##",$package);
		$package1_name = $package_array[0];
		$package1_num = $package_array[1];
		$package1_value = $package_array[2];
		$package2_name = $package_array[3];
		$package2_num = $package_array[4];
		$package2_value = $package_array[5];
		$package3_name = $package_array[6];
		$package3_num = $package_array[7];
		$package3_value = $package_array[8];
		$package4_name = $package_array[9];
		$package4_num = $package_array[10];
		$package4_value = $package_array[11];
			
		
		echo "<tr>";
		echo "<td>".$count++."</td>";
		echo "<td>".$barcode."</td>";
		echo "<td>";
		//if ($third_party!="")
		//echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
		if ($package1_name!="")
		echo "$package1_name ($package1_num)";
		if ($package2_name!="")
		echo ",$package2_name ($package2_num)";
		if ($package3_name!="")
		echo ",$package3_name ($package3_num)";
		if ($package4_name!="")
		echo ",$package4_name ($package4_num)";
		echo "</td>";
		
		echo "<td>".$weight."</td>";	
		$total_weight+=$weight;
		//echo "<td>";
		//echo anchor("customer/orders_detail/".$order_id,"Дэлгэрэнгүй",array("class"=>"btn btn-xs btn-success"));
	
		//if ($status=="weight_missing") echo anchor("customer/orders_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
		//echo "</td>";
		echo "</tr>";	
		}
	}
	}
	
	echo "<tr><td colspan='3' align='right'>Нийт жин (Кг)</td><td>$total_weight</td></tr>";
	echo "<tr><td colspan='3' align='right'>Төлбөр($)</td><td>".cfg_price($total_weight)."</td></tr>";
	echo "<tr><td colspan='3' align='right'>НӨАТ</td><td>0</td></tr>";
	echo "<tr><td colspan='3' align='right'>Нийт төлбөр($)</td><td>".cfg_price($total_weight)."</td></tr>";									echo "<tr><td colspan='3' align='right'>Нийт төлбөр(₮) үүсгэсэн өдрийн ханшаар</td><td>".$amount."</td></tr>";
	echo "</table>";

	echo "<a onClick=\"window.print()\" class=\"btn btn-lg btn-warning\"><span class='glyphicon glyphicon-print'></span>Хэвлэх</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	
	echo "<a onClick=\"window.close()\" class=\"btn btn-lg btn-danger\"><span class='glyphicon glyphicon-remove'></span>Гарах</a>";
}
else echo "Илгээмжийг сонгоогүй байна.";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
	<? 
	}
	?>
