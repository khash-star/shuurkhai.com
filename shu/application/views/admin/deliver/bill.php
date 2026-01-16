<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body{padding: 0px;}
@media print{ .btn {display:none;} hr {border-bottom:2px #000000 solid;}} 
hr {border-bottom:2px #000000 solid;}
</style>
<? if ($this->uri->segment(3)) $deliver_id=$this->uri->segment(3) ?>
<? if ($this->uri->segment(4)) $orders=$this->uri->segment(4) ?>
<? if ($this->uri->segment(5)) $method=$this->uri->segment(5) ?>
	<img src="<?=base_url("assets/images/logo.png");?>" style="max-width:300px; width:80%;margin-top: 0px;">  
      
<? 	
	$query_deliver = $this->db->query('SELECT * FROM customer WHERE customer_id="'.$deliver_id.'"');
	if($query_deliver->num_rows()==1)
			{
			$row=$query_deliver->row();
			$deliver_name=$row->name;
			$deliver_tel=$row->tel;
			}
    $query_bill = $this->db->query('SELECT * FROM bills WHERE deliver="'.$deliver_id.'" ORDER BY id DESC LIMIT 1');
	if($query_bill->num_rows()==1)
			{
			$row_bill=$query_bill->row();
			$bill_id=$row_bill->id;
			//$deliver_tel=$row->tel;
			}
 	
	echo "<br>";
	echo "№".$bill_id;
	echo "<br>";
	echo "Гардан авсан: $deliver_name <br>$deliver_tel";
	echo "<br>";
	echo date("Y-m-d H:i:s");
	echo "<br>";
	if ($method=="cash") echo "Төлбөрийг бэлнээр";
	if ($method=="pos") echo "Карт уншуулсан";
	if ($method=="account") echo "Дансаар шилжүүлсэн";
	if ($method=="later") echo "Дараа тооцоотой";
	echo "<br>";
	echo "<br>";
	
	$orders_array = explode(',',$orders);
	$N = count($orders_array);
	$count=1; $total_weight=0;$total_price=0;$total_advance=0;$total_weight_branch=0;$grand_totat=0;
		echo '<table>';
		echo '<tr><td>Ачаа</td><td>Жин</td></tr>';
		echo '<tr><td colspan="2"><hr></td></tr>';
		for($i=0; $i < $N; $i++)
		{
		$sql="SELECT * FROM orders WHERE order_id='".$orders_array[$i]."' LIMIT 1";
		$query= $this->db->query($sql);
			if ($query->num_rows()==1)
			{
			$row=$query->row();
			$order_id=$row->order_id;
			$created_date=$row->created_date;
			$sender=$row->sender;
			$receiver=$row->receiver;
			$deliver=$row->deliver;
			$barcode=$row->barcode;
			$track=$row->third_party;
			$weight=floatval($row->weight);
			$advance=$row->advance;
			$advance_value=floatval($row->advance_value);
			$status=$row->status;
			$method=$row->method;
			$is_online  = $row->is_online;
			$is_branch=$row->is_branch;
			$extra = $row->extra;

			  
			if($status=="warehouse"&&$extra!="") 
			$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
			echo "<tr>";
			echo "<td>".$count++.".".$barcode."<br>".customer($receiver,"name");
			//echo "<br>"; 
			//if ($is_online) echo "/collect/"; elseif($advance_value==0) echo "/paid/";
			
			echo "</td>";
			echo "<td>".$weight."Кг</td>";
	   		echo "<td>"; if ($is_online) $advance_value."$"; echo "</td>"; 
	   		echo "</tr>";
			// if ($is_online) $total_weight+=$weight; else $total_advance+=$advance_value; 
			if ($is_online==1) 
				{
					if ($is_branch)
					$total_weight_branch+=floatval($weight);
					else  
					$total_weight+=floatval($weight);
				}
				else $total_advance+=$advance_value; 

			}
			// $total_admin_value+=$admin_value;

		}
		echo '<tr><td colspan="2"><hr></td></tr>';

		echo "</table>";

		
		echo '<table class="table">';

		//echo "<tr><td colspan='2'>Нийт жин /Кг/</td><td >$total_weight</td><td></td></tr>";
		//echo "<tr ><td colspan='2'>Ачааны тооцоо /$/</td><td >".cfg_price($total_weight)."$</td></tr>";
		//echo "<tr ><td colspan='2'>Дараа тооцоо /$/</td><td >".$total_advance."$</td></tr>";
		if ($total_advance==0) 
		$grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);
		else $grand_total =$total_advance;

		// $total_price = $total_advance+cfg_price($total_weight);
		echo "<tr ><td colspan='2'>Нийт тооцоо /$/ &nbsp;&nbsp;&nbsp;".$grand_total."$</td></tr>";
		echo "<tr ><td colspan='2'>Нийт төлбөр /₮/&nbsp;&nbsp;&nbsp;".$grand_total*cfg_rate()."₮</td></tr>";
		echo "</table>";
	
		
	
		echo "<a onClick='window.print();window.close();' class='btn btn-warning btn-xs'><i class='fa fa-print'></i>Хэвлэх</a>";
		echo "<P align='center'>Танд баярлалаа</P>...<br>..<br>.";
			
?>