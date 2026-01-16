<div class="panel panel-primary">
  <div class="panel-heading">Идэвхитэй захиалгууд</div>
  <div class="panel-body">

<? 
$xls_name = date("ymd").rand(0,10000).".xlsx";
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	if ($search_term!="") echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["status"])) $search_status=$_POST["status"]; else $search_status='all';

if (isset($_POST["status_type"])) $statuts_type=$_POST["status_type"]; else $statuts_type='all';


if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 month'))." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


if(isset($_POST["search_date"]))  $search_date =$_POST["search_date"]; else  $search_date ="created";


//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
$sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term."%'";

if ($search_status=="all") 
$sql.=" AND orders.status NOT IN('completed','delivered','warehouse','custom')";
if ($search_status=='db')
$sql.=" AND orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";

if ($search_status!="all" && $search_status!='db' && $search_status!='transport')
$sql.=" AND orders.status ='$search_status'";

if ($statuts_type=="advance")
$sql.=" AND orders.advance=1";

if ($search_status=="transport")
$sql.=" AND orders.transport=1";

$sql.=" AND is_online='0'";

switch($search_date)
{
	case "created": $date_column = "created_date";break;
	case "onair": $date_column = "onair_date";break;
	case "warehouse": $date_column = "warehouse_date";break;
	case "delivered": $date_column = "delivered_date";break;
	
}
if ($start_date!="")  $sql.=" AND ".$date_column.">'$start_date'";
if ($finish_date!="")  $sql.=" AND ".$date_column."<'$finish_date'";



$sql.=" ORDER BY created_date DESC";

//echo $sql;
$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	//echo form_open("orders/changing");
     echo "<table class='table table-hover small'>";
	 echo "<tr>";
	   //echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
       //echo "<th>Илгээгч</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th>Х/авагч утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   //echo "<th>Track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   //echo "<th>Төлбөр</th>"; 
	   echo "<th>Үлдэгдэл</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_price=0;
	  $data = array(
    array('Илгээгч','','','','Хүлээн авагч','','','','Barcode','Track','Төлөв','Жин','Үнэлгээ','Төлбөртэй','Тайлбар'),
	array('Овог','Нэр','Утас','Хаяг','Овог','Нэр','Утас','Хаяг','','','','','','',''));
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		//$price=$row->price;
		//$description=$row->description;
		//$sender_id=$row->s_name;
  	 	$sender=$row->s_name;
		$sender_surname=$row->s_surname;
		$sender_contact=$row->s_tel;
		$sender_address=$row->s_address;
		$sender_id=$row->sender;
   		$receiver=$row->r_name;
		$receiver_id=$row->receiver;
		$receiver_surname=$row->r_surname;
		$receiver_contact=$row->r_tel;
		$receiver_address=$row->r_address;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->package;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$extra=$row->extra;
		$third_party=$row->third_party;
		$status=$row->status;
		$total_weight+=$weight;
		$total_price+=floatval($Package_advance_value);
		$transport = $row->transport;
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
	  // echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date;
	   	if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

	   echo "</td>"; 
       //echo "<td>".$sender."</td>"; 
	   //echo "<td>".$receiver."</td>";
	   //echo "<td>"; if($sender!="") echo anchor("customers/detail/".$sender_id,$sender); echo "</td>"; 
	   
		echo "<td>".
		anchor("admin/customers_detail/".$sender_id,substr($sender_surname,0,2).".".$sender).
		"-><br>".
		 anchor("admin/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver);
		 echo "</td>";
	   echo "<td>";
	   echo $sender_contact."-><br>".$receiver_contact;
	   echo "</td>"; 
	   echo "<td>".barcode_comfort($barcode)."</td>"; 
	   //echo "<td>".$third_party."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$weight."</td>"; 
	  // echo "<td>".$weight*cfg_paymentrate()."</td>"; 
	   echo "<td>".$Package_advance_value."</td>"; 
	   echo "<td>".anchor('admin/orders_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
 array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address,$barcode,$third_party,$temp_status,floatval($weight),floatval($weight*cfg_paymentrate()),floatval($Package_advance_value),$description));		
	} 
	 echo "<tr><td colspan='7'>Нийт</td><td>$total_weight</td><td>".$total_weight*cfg_paymentrate()."</td><td>$total_price</td><td></td></tr>";
	 echo "</table>";
	 array_push($data,array('Нийт','','','','','','','','','','',floatval($total_weight),floatval(cfg_price2($total_weight)),floatval($total_price)));

	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	
	$options = array(
				  ''  => 'Шинэ төлөвийн сонго',
                  'delivered'  => 'Хүргэж өгөх',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад орсон',
                  'custom' => 'Гааль',
				 // 'delete' => 'Barcode устгах',
                );


	//echo form_dropdown('options', $options, '', array("class"=>"form-control"));
	//echo "<div id='more'></div>";
	//echo form_submit("submit","өөрчил", array("class"=>"btn btn-success"));
	//echo form_close();
	
	
	

}
else echo "Илгээмж олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?
	if (isset($total_weight))
	{
		?>
		<div class='foot_follower'>
		<?	echo "<b>Нийт</b>&nbsp;&nbsp;&nbsp;&nbsp;".$total_weight."Kg&nbsp;&nbsp;&nbsp;&nbsp;"; ?>

		<?=anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));?>
		</div>
		<?
	}
	?>
	

<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>