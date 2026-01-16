<? 
//if(isset($_POST["search"])) 
//	{
//	$search_term=$_POST["search"];
//	echo "Xайлт:".$search_term."<br>";
//	}
//	else $search_term="";
//if (isset($_POST["type"])) $type=$_POST["type"]; else $type='all';

if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date("Y-m-d")." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT * FROM works WHERE";

if ($start_date!="")  $sql.=" timestamp>'$start_date'";
if ($finish_date!="")  $sql.=" AND timestamp<'$finish_date'";

//echo $sql;

/*if(isset($_POST["search"])) 
$sql.=" AND CONCAT_WS(barcode,package,sender_customer.name,sender_customer.tel,receiver_customer.name,receiver_customer.tel) LIKE '%".$_POST["search"]."%'";*/

$sql.=" ORDER BY works_id DESC";

//echo $sql;



//
//$sql.=" ORDER BY created_date DESC";
//echo $sql;
$query = $this->db->query($sql);

//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th>№</th>"; 
		//echo "<th>Үүсгэсэн огноо</th>"; 
      	echo "<th>Гардаж авсан</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "<th>Ачаа</th>";
	    echo "<th>Жин</th>";  
	   echo "<th>Агуулахад үлдсэн</th>"; 
	   echo "</tr>";
		$count=1;$total_weight=0;$total_price=0;$total_advance=0;

		foreach ($query->result() as $row)
			{
			//$row=$query->row();
			$deliver_id=$row->customer_id;
			$created_date=$row->created_date;
			$delivered_date=$row->delivered_date;
			$sender=$row->sender;
			//$sender_name=$row->sender_customer.name;
			//$sender_surname=$row->sender_customer.name;
			$receiver=$row->receiver;
			//$receiver_name=$row->receiver_customer.name;
			//$receiver_surname=$row->receiver_customer.surname;
			$deliver=$row->deliver;
			$barcode=$row->barcode;
			$track=$row->third_party;
			$weight=$row->weight;
			$advance=$row->advance;
			$advance_value=$row->advance_value;
			$status=$row->status;
			$is_online=$row->is_online;
			if ($is_online)
			$price=$weight*cfg_paymentrate(); else $price=0;
			if($status=="warehouse"&&$extra!="") 
			$temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status;
			
			$tr=0;
			$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
			
			
			if ($advance==1&&$is_online==0)
				{echo "<tr class='red' title='Үлдэгдэлтэй илгээмж:".$Package_advance_value."$' alt='order'>"; $tr=1;}
				
				if ($advance==0&&$is_online==0&&$tr==0)
				{echo "<tr class='green' title='Илгээмжийг шууд олго төлбөргүй' alt='order'>"; $tr=1;}
			
				if (!$tr) echo "<tr>";else $tr=0;
			
			
			
			
			
	    	echo "<td>".$count++."</td>"; 
			//echo "<td>".$created_date."</td>"; 
			echo "<td>".anchor("admin/customers_detail/".$sender,substr(customer($sender,"surname"),0,2).".".customer($sender,"name"))."<br>".customer($sender,"tel")."</td>";
			echo "<td>".anchor("admin/customers_detail/".$receiver,substr(customer($receiver,"surname"),0,2).".".customer($receiver,"name"))."<br>".customer($receiver,"tel")."</td>";
			echo "<td>".anchor("admin/customers_detail/".$deliver,substr(customer($deliver,"surname"),0,2).".".customer($deliver,"name"))."<br>".customer($deliver,"tel")."</td>";

			echo "<td>".$delivered_date."<br>"; 
			echo barcode_comfort($barcode)."<br>"; 
	   if ($track!="")
	echo "<a href='".track($track)."' target='new' title='Хаана явна'>$track<span class='glyphicon glyphicon-globe'></span></a>";
	   		echo "</td>";
			//echo "<td>".days($created_date)."</td>"; 
	   		//echo "<td>".$temp_status."</td>"; 
			echo "<td>".$weight."</td>"; 
	   		//echo "<td>".$weight*cfg_paymentrate()."</td>"; 
	   		echo "<td>".$advance_value."</td>"; 
			if ($is_online)
			echo "<td>".anchor('admin/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
			else 
			echo "<td>".anchor('admin/orders_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>";
	   		echo "</tr>";
			$total_weight+=$weight;
			$total_price+=$price;
			$total_advance+=$advance_value;

		}
		echo "<tr class='total'><td colspan='7'>Нийт:( $total_weight Кг ) $total_price $</td></tr>";
	echo "</table>";

}
else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';


?>