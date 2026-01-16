<? 
//$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";

$sql="SELECT count(*) COUNT_T,sum(weight) SUM_T FROM orders WHERE status='new' AND agents='".$this->session->userdata("agent_id")."' AND is_online='0' GROUP BY status";
$query = $this->db->query($sql);
foreach ($query->result() as $row)
	{  
		$count_total=$row->COUNT_T;
		$sum_total=$row->SUM_T;
	}

	$sql="SELECT count(*) COUNT_T,sum(weight) SUM_T FROM orders WHERE status='new' AND agents='".$this->session->userdata("agent_id")."' AND is_online='0' AND advance=1 GROUP BY status";
	$query = $this->db->query($sql);
	foreach ($query->result() as $row)
		{  
			$count_total2=$row->COUNT_T;
			$sum_total2=$row->SUM_T;
		}

	$TOTAL_DIFF = $count_total-$count_total2;
	$SUM_DIFF = $sum_total-$sum_total2;
// echo $sql;



require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	if ($search_term!="") echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["status"])) $search_status=$_POST["status"]; else $search_status='all';

if (isset($_POST["status_type"])) $statuts_type=$_POST["status_type"]; else $statuts_type='all';
//echo "Хайх:".$search_term."<br>";
//echo "search:".$_POST["search"];
//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*,senders.name AS s_name,senders.surname AS s_surname,senders.tel AS s_contact,senders.address AS s_address,receivers.surname AS r_surname,receivers.name AS r_name,receivers.tel AS r_contact,receivers.address AS r_address 
FROM orders 
JOIN customer AS senders ON orders.sender=senders.customer_id 
LEFT JOIN customer AS receivers ON orders.receiver=receivers.customer_id";

if ($search_status=="all") 
$sql.=" WHERE orders.status NOT IN('completed','delivered','warehouse','custom')";
if ($search_status=='db')
$sql.=" WHERE orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
if ($search_status!="all" && $search_status!='db')
$sql.=" WHERE orders.status ='$search_status'";

if ($statuts_type=="advance")
$sql.=" AND orders.advance=1";

//if(isset($_POST["search"])) 
$sql.=" AND LOWER(CONVERT(CONCAT_WS(barcode,package,senders.name,senders.tel,receivers.name,receivers.tel,created_date)USING utf8)) LIKE '%".($search_term)."%'";
$sql.= " AND agents='".$this->session->userdata("agent_id")."'";
$sql.= " AND is_online='0'";
$sql.=" ORDER BY created_date DESC";

//echo $sql;


//echo $sql;
echo '<div class="panel panel-primary">';
echo '<div class="panel-heading">New-'.$count_total.' ('.number_format($sum_total,2).'Kg) &nbsp;&nbsp;&nbsp;   Монголд төлөх-'.$count_total2.' ('.number_format($sum_total2,2).'Kg) &nbsp;&nbsp;&nbsp; US Paid-'.$TOTAL_DIFF.' ('.number_format($SUM_DIFF,2).'Kg)</div>';
echo '<div class="panel-body">';

$query = $this->db->query($sql);
//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	//echo form_open("agents/changing");
     echo "<table class='table table-hover small'>";
	 echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Хүлээн авагчын утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>";
	   //echo "<th>Үлдэгдэл</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_price=0;
	   $data = array(
   array('Илгээгч','','','','Хүлээн авагч','','','','Barcode','Төлөв','Жин','Үнэлгээ','Үлдэгдэл','Тайлбар'),
	array('Овог','Нэр','Утас','Хаяг','Овог','Нэр','Утас','Хаяг','','','','','',''));
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
		$sender_id=$row->sender;
  	 	$sender=$row->s_name;
		$sender_surname=$row->s_surname;
		$sender_contact=$row->s_contact;
		$sender_address=$row->s_address;
   		$receiver=$row->r_name;
		$receiver_id=$row->receiver;
		$receiver_surname=$row->r_surname;
		$receiver_contact=$row->r_contact;
		$receiver_address=$row->r_address;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->package;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$extra=$row->extra;
		$status=$row->status;
		$total_weight+=intval($weight);
		//$total_price+=$Package_advance_value;
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
		
	  	if ($Package_advance==1&&!$tr)
		{echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
		
		if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
		if (!$tr) echo "<tr>";else $tr=0;
		
	   //echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
	   echo "<td>".anchor('agents/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."".$count++."</td>"; 
	   echo "<td>".$created_date."</td>"; 
		echo "<td>".anchor("agents/customers_detail/".$sender_id,substr($sender_surname,0,2).".".$sender)."</td>";
		echo "<td>".anchor("agents/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver)."</td>";
	   echo "<td>".$receiver_contact."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$weight."</td>"; 
	   echo "<td>".$Package_advance_value."</td>"; 
	  // echo "<td>".$Package_advance_value."</td>"; 
	    
	   echo "<td>".anchor('agents/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
 array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$barcode,$temp_status,floatval($weight),floatval($weight*cfg_paymentrate()),floatval($Package_advance_value),$description));

	} 
	 echo "<tr><td colspan='8'>Нийт</td><td>$total_weight</td><td>".cfg_price2($total_weight)."</td><td>$total_price</td><td></td></tr>";
	 $xls_name = "agents_box.xlsx";
	 array_push($data,array('Нийт','','','','','','','','','',floatval($total_weight),floatval($total_weight*cfg_paymentrate()),floatval($total_price)));
	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	echo "</table>";
	
	/*$options = array(
				  //''  => 'Шинэ төлөвийн сонго',
                  //'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор ирж байгаа',
                 // 'warehouse'   => 'Агуулахад орсон',
                  //'custom' => 'Гааль',
				 // 'delete' => 'Barcode устгах',
                );


	echo form_dropdown('options', $options, '');
	echo "<div id='more'></div>";
	echo form_submit("submit","өөрчил");
	echo form_close();*/
	
	echo "</table>";
	echo "<br><br><br><br>".anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));

}
else echo "Илгээмж олдсонгүй<br>";

echo '</div>';
echo '</div>';
?>