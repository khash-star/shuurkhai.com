<style>
#table_dd td{padding:3px 1px 3px 0px; max-width:200px;}
</style>
<? 
//$xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	if ($search_term!="") echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["status"])) $search_status=$_POST["status"]; else $search_status='all';
if (isset($_POST["status_type"])) $statuts_type=$_POST["status_type"]; else $statuts_type='all';


$start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";

$finish_date = date("Y-m-d")." 23:59:00";





$sql="SELECT * FROM orders";

$sql.=" WHERE created_date>'$start_date'";

if ($search_status=="all") 
$sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom','onair')";
if ($search_status=='db')
$sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";

if ($search_status!="all" && $search_status!='db')
$sql.=" AND orders.status ='$search_status'";

if ($statuts_type=="advance")
$sql.=" AND orders.advance=1";

if(isset($_POST["search"])) 
$sql.=" AND LOWER(CONVERT(CONCAT_WS(barcode,package,third_party,created_date)USING utf8)) LIKE '%".$search_term."%'";
$sql.=" AND is_online='1'";

$sql.=" ORDER BY created_date DESC";
// echo $sql;

//echo '<div class="panel panel-primary">';
//echo '<div class="panel-heading">Track</div>';
//echo '<div class="panel-body">';
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
// 	   $data = array(
//     array('Хүлээн авагч','','','','','Barcode','Track№','Төлөв','Жин','Тайлбар'),
// 	array('Нэр','Овог','РД','Утас','Хаяг'));
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
   		
		$receiver_id=$row->receiver;
		$proxy=$row->proxy_id;
		$proxy_type=$row->proxy_type;

		$receiver=customer($receiver_id,"||");

		$receiver_info = explode("||", $receiver);
		if (array_key_exists(2, $receiver_info)) $surname  = $receiver_info[2]; else $surname="";
		//echo $count.$receiver."[".count($receiver_info)."]<br>";
		$barcode=$row->barcode;
		$description=$row->package;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$third_party = $row->third_party;
		$extra=$row->extra;
		$print=$row->print;
		$status=$row->status;
		$is_branch = $row->is_branch;
		$total_weight+=floatval($weight);
		$total_price+=floatval($Package_advance_value);
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

		if ($status=='received'&&!$tr)
		{echo "<tr class='yellow' title='Жин бөглөгдөөгүй байна:'>"; $tr=1; $class="maroon";}
		
		if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
		if (!$tr) echo "<tr>";else $tr=0;
	   echo "<td class='$class'><span class='$class'></span>".$count++."</td>"; 
	   echo "<td  class='$class'>".substr($created_date,0,10)."</td>"; 
	   echo "<td class='$class'>".anchor("agents/customers_detail/".$receiver_id,$receiver_info[0]);//.count_new_receiver($receiver_id);
	   if ($proxy<>0) echo "<br>";
			if ($proxy_type==1) echo "<span style='color:#F00' title='Public proxy'>";
				echo proxy2($proxy,$proxy_type,"name");
			if ($proxy_type==1) echo "</span>";
	   echo "</td>";

	   echo "<td  class='$class'>".$surname."</td>"; 
	   echo "<td  class='$class'>".$barcode."<br>"; 
	   if ($third_party!="")
			echo $third_party;
		if ($is_branch) echo '<span class="badge badge-success">DE</span>';
	   echo "</td>"; 
	   echo "<td  class='$class'>".$days."</td>"; 
	   echo "<td  class='$class'>".$temp_status."</td>";
	   echo "<td  class='$class'>"; echo $weight; if($weight>0) "Kg";echo "</td>"; 
	   echo "<td  class='$class'>";
	   if ($is_branch)  echo cfg_price_branch($weight); else echo cfg_price($weight);
	   echo "$</td>"; 
	   ?>
	   <td class="<?=$class;?>" >
	       <a href="tracks_detail/<?=$order_id;?>">More</a><br>
	       <a href="tracks_preview/<?=$order_id;?>" title="CP72 хэвлэх" target="_blank">Print</a><br>
	   </td>
	   <?
	   echo "</tr>";
	   $class="";
	   
 		//array_push($data,array($receiver,$receiver_surname,$receiver_rd,$receiver_contact,$receiver_address,$barcode,strval($third_party),$temp_status,floatval($weight),$description));

	} 
	 echo "</tbody>";
	echo "</table>";
	echo "<div class='clearfix' style='margin-top:100px;'></div>";
	

	echo "<div class='foot_follower'>";
	echo "<b>Нийт</b>&nbsp;&nbsp;&nbsp;&nbsp;".$total_weight."Kg&nbsp;&nbsp;&nbsp;&nbsp;";
	//array_push($data,array('Нийт','','','','','','','',floatval($total_weight),''));
	//$writer = new XLSXWriter();
	//$writer->writeSheet($data);
	//$writer->writeToFile('assets/xlsx/'.$xls_name);
	//echo "".anchor(base_url().'assets/xlsx/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));
	echo "</div>";
}
else echo "Илгээмж олдсонгүй<br>";

//echo '</div>';
//echo '</div>';
?>


<script language="javascript">
$(document).ready(function(){
 // $('#table_dd').dynatable();
	$("td:contains('new')").parent().addClass("red");
	$("td:contains('weight_missing')").parent().addClass("yellow");
	$("td:contains('onair')").parent().addClass("green");
});

</script>
