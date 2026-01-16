<?php
// $xls_name = "delivered".date("ymd").rand(0,10000).".xlsx";
$xls_name = "delivered.xlsx";

require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');





 
if(isset($_POST["search"])) 
	{
	$search_term=$_POST["search"];
	echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["type"])) $type=$_POST["type"]; else $type='all';

if (isset($_POST["method_type"])) $method_type=$_POST["method_type"]; else $method_type='all';

if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -7 days'))." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*,receiver_customer.name AS r_name,receiver_customer.tel AS r_tel,sender_customer.name AS s_name,sender_customer.tel AS s_tel,deliver_customer.name AS d_name, deliver_customer.tel AS d_name, CONCAT_WS(orders.barcode,orders.third_party,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel,deliver_customer.name,deliver_customer.tel) AS search FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id LEFT JOIN customer AS deliver_customer ON orders.deliver=deliver_customer.customer_id";
$sql.=" WHERE CONCAT_WS(orders.barcode,orders.third_party,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel,deliver_customer.name,deliver_customer.tel) LIKE '%".$search_term."%'";

$sql.=" AND orders.status IN ('delivered','custom')";
if ($type=="advance") $sql.=" AND orders.advance =1";

if ($method_type!="all") $sql.=" AND orders.method ='$method_type'";


if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";

//echo $sql;

/*if(isset($_POST["search"])) 
$sql.=" AND CONCAT_WS(barcode,package,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel) LIKE '%".$_POST["search"]."%'";*/

//$sql.=" ORDER BY receiver_customer.name";
$sql.=" ORDER BY delivered_date DESC";

//echo $sql;



//
//$sql.=" ORDER BY created_date DESC";
//echo $sql;
$query = $this->db->query($sql);

//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover table-bordered'>";
		echo "<tr>";
		echo "<th>№</th>"; 
		//echo "<th>Үүсгэсэн огноо</th>"; 
      //	echo "<th>Илгээгч</th>"; 
	   echo "<th>Х/авагч</th>"; 
	   echo "<th>Гардсан</th>"; 
	   echo "<th>Олгосон огноо/Barcode/track</th>"; 
	   //echo "<th>Хоног</th>"; 
	   echo "<th>Жин</th>"; 
	   //echo "<th>Төлбөр</th>"; 
	   echo "<th>Үлдэгдэл</th>";
	    echo "<th>Арга</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
		$count=1;$total_weight=0;$total_price=0;$total_advance=0;$total_weight_branch=0;$total_admin_value=0;



 	$data = array(
    array('№','Илгээгч','Х/авагч','Х/а утас','Гардагч','Гардсан утас','Олгосон огноо','Barcode','Track№','Жин','Үлдэгдэл','Арга'));
	
	
		foreach ($query->result() as $row)
			{
			//$row=$query->row();
			$order_id=$row->order_id;
			$created_date=$row->created_date;
			$delivered_date=$row->delivered_date;
			$sender=$row->sender;
			//$sender_name=$row->sender_customer.name;
			//$sender_surname=$row->sender_customer.name;
			$receiver=$row->receiver;
			//$receiver_name=$row->receiver_customer.name;
			//$receiver_surname=$row->receiver_customer.surname;
			$admin_value=$row->admin_value;

			$deliver=$row->deliver;
			$barcode=$row->barcode;
			$track=$row->third_party;
			$weight=floatval($row->weight);
			$advance=$row->advance;
			$advance_value=floatval($row->advance_value);
			$status=$row->status;
			$method=$row->method;
			$Package_advance = $row ->advance;
			$Package_advance_value =$row->advance_value;

			$is_online=$row->is_online;
			$is_branch=$row->is_branch;
			if ($is_online)
			$price=$weight*cfg_paymentrate(); else $price=0;
			if($status=="warehouse"&&$extra!="") 
			$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;

			if ($is_online==1) 
			{
				if ($is_branch)
				$total_weight_branch+=floatval($weight);
				else  
				$total_weight+=floatval($weight);
			}
				
			$total_admin_value+=$admin_value;

			if ($is_online==0 && $Package_advance==1)
			$total_advance+=floatval($Package_advance_value);



			$tr=0;
			if ($advance==1&&$is_online==0)
				{echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$advance_value."$' alt='order'>"; $tr=1;}
				
				if ($advance==0&&$is_online==0&&$tr==0)
				{echo "<tr class='green' title='Илгээмжийг шууд олгосон төлбөргүй' alt='order'>"; $tr=1;}
			
				if (!$tr) echo "<tr>";else $tr=0;
			
			
	    	echo "<td>".$count."</td>"; 
			echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."<br>".customer($receiver,"tel")."</td>";
			echo "<td>".anchor("admin/customers_detail/".$deliver,substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"))."<br>".customer($deliver,"tel")."</td>";

			echo "<td>".$delivered_date."<br>"; 
			echo barcode_comfort($barcode)."<br>"; 
			if ($track!="")
			echo "<a href='".track($track)."' target='new' title='Хаана явна'>$track<span class='glyphicon glyphicon-globe'></span></a>";
			if ($is_branch) echo '<span class="badge badge-success">DE</span>';
	   		echo "</td>";
			//echo "<td>".days($created_date)."</td>"; 
	   		//echo "<td>".$temp_status."</td>"; 
			echo "<td>".$weight."</td>"; 
	   		//echo "<td>".$weight*cfg_paymentrate()."</td>"; 
	   		echo "<td>".$advance_value."</td>"; 
			echo "<td>";
			if ($status=="custom") echo $status."<br>";
			echo $method."</td>"; 
			if ($is_online)
			echo "<td>".anchor('admin/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
			else 
			echo "<td>".anchor('admin/orders_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
	   		echo "</tr>";
			// $total_weight+=$weight;
			// $total_price+=$price;
			// $total_advance+=intval($advance_value);
			
			
			
			 array_push($data,array(
			 $count,
			 substr(customer($sender,"surname"),0,2).".".customer($sender,"name"),
			 substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"),
			 customer($receiver,"tel"),
			 substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"),
			 customer($deliver,"tel"),
			 $delivered_date,
			 $barcode,
			 "  ".strval($track),
			 $weight, 
	   		 $advance_value, 
			 $method));

			$count++;
		}
		// $grand_total = cfg_price($total_weight);

		if ($total_advance==0) 
		$grand_total = cfg_price($total_weight) + cfg_price_branch($total_weight_branch);
		else $grand_total =$total_advance;

		$gt_weight  = $total_weight  +  $total_weight_branch;
		echo "<tr class='total'><td colspan='7'>Нийт:( $gt_weight Кг ) $grand_total $</td></tr>";
		
		
	array_push($data,array('','Нийт','','','','','','','',floatval($gt_weight),floatval($grand_total)));
	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	
	
	echo "</table>";

}
else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';


?>
<?=anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));?>
