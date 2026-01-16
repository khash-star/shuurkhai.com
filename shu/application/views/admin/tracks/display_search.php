<style>
#table td{padding:3px 1px 3px 0px;}
th,td  { max-width:150px !important; overflow:auto;}
</style>
<? 
// $xls_name = "agent".date("ymd").rand(0,10000).".xlsx";
$xls_name = "tracks.xlsx";
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

//echo "Хайх:".$search_term."<br>";
//echo "search:".$_POST["search"];
//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*,receivers.name AS receiver_name,receivers.tel AS receiver_contact,receivers.address AS receiver_address, receivers.rd AS receiver_rd,receivers.surname AS receiver_surname FROM orders LEFT JOIN customer AS receivers ON orders.receiver=receivers.customer_id";

if ($search_status=="all") 
$sql.=" WHERE orders.status NOT IN('completed','delivered','warehouse','custom')";
if ($search_status=='db')
$sql.=" WHERE orders.status IN ('completed','delivered','warehouse','custom','onair','new','order','weight_missing','item_missing','filled')";
if ($search_status=='transport')
$sql.=" WHERE orders.status NOT IN('completed','delivered')";

if ($search_status!="all" && $search_status!='db' && $search_status!='transport')
$sql.=" WHERE orders.status ='$search_status'";

if ($statuts_type=="advance")
$sql.=" AND orders.advance=1";

if ($search_status=="transport")
$sql.=" AND orders.transport=1";

//if(isset($_POST["search"])) 
$sql.=" AND LOWER(CONVERT(CONCAT_WS(barcode,package,receivers.name,receivers.tel,third_party,created_date)USING utf8)) LIKE '%".$search_term."%'";
//$sql.=" AND agents IN ('".$this->session->userdata("agent_id")."', '0')";

$sql.=" AND is_online='1'";
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

echo '<div class="panel panel-primary">';
echo '<div class="panel-heading">Track</div>';
echo '<div class="panel-body">';
$query = $this->db->query($sql);
 $count=0;$total_weight=0;$total_price=0;
//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	// echo form_open("agents/tracks_changing");
     echo "<table class='table table-hover small' id='table'>";
	 echo "<tr>";
	  // echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
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
	   $count=1;
	   $data = array(
    array('Хүлээн авагч','','','','','Barcode','Track№','Төлөв','Жин','Үлдэгдэл','Тайлбар'),
	array('Нэр','Овог','РД','Утас','Хаяг'));
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
   		$receiver=$row->receiver_name;
		$receiver_surname=$row->receiver_surname;
		$receiver_id=$row->receiver;
		$receiver_contact=$row->receiver_contact;
		$receiver_address=$row->receiver_address;
		$receiver_rd=$row-> receiver_rd;
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
		$total_weight+=floatval($weight);
		$total_price+=floatval($Package_advance_value);
		$owner=$row->owner;
		$is_branch = $row->is_branch;
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;
		$days=ceil($days);
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
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date;
	if ($transport) echo "<br><span class='glyphicon glyphicon-home' title='Улаанбаатарт хүргэлттэй'></span> Хүргэлттэй"; 

	   echo "</td>"; 
	   echo "<td>"; //anchor("admin/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver);
		//echo "<br>";
			if (proxy2($proxy,$proxy_type,"name")<>"") 
				{
					echo "<td>";
					echo anchor("admin/customers_proxy/".$receiver_id,proxy2($proxy,$proxy_type,"name"),array('style'=>'color:gray'));
					echo "</td>";
					echo "<td>";
					echo anchor("admin/customers_proxy/".$receiver_id,proxy2($proxy,$proxy_type,"tel"),array('style'=>'color:gray'));
					echo "</td>";
				}
				else
				{
				echo "<td>";
				echo anchor("admin/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver);
				echo "</td>";
				 echo "<td>".$receiver_contact."</td>"; 
				}
				 

					
		

	  
	   echo "<td class='track_td'>".barcode_comfort($barcode)."<br>"; 
	   if ($third_party!="")
	   echo "<a href='".track($third_party)."' target='new' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
	   if ($is_branch) echo '<span class="badge badge-success">DE</span>';
	   if ($owner==2) echo "SH";
	   echo "</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$weight."</td>"; 
	   echo "<td>".$Package_advance_value."</td>"; 
	   //echo "<td>".anchor('agents/tracks_detail/'.$row->order_id,'<img src="'.base_url().'assets/more.png" class="more" title="дэлгэрэнгүй">')."</td>"; 
	   echo "<td>".anchor('admin/tracks_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
 array_push($data,array($receiver,$receiver_surname,$receiver_rd,$receiver_contact,$receiver_address,$barcode,"  ".strval($third_party),$temp_status,floatval($weight),floatval($Package_advance_value),$description));

	} 
	 echo "<tr><td colspan='7'>Нийт ($total_weight Кг) $total_price</td></tr>";
	 array_push($data,array('Нийт','','','','','','','',floatval($total_weight),floatval($total_price),$description));
	$writer = new XLSXWriter();
	$writer->writeSheet($data);
	$writer->writeToFile('assets/'.$xls_name);
	echo "</table>";
	//echo "<br><br><br><br>".anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'button'));

}
else echo "Илгээмж олдсонгүй<br>";

echo '</div>';
echo '</div>';
?>

<div class='foot_follower'>
<?	echo "<b>Нийт</b>&nbsp;&nbsp;&nbsp;&nbsp;".$total_weight."Kg&nbsp;&nbsp;&nbsp;&nbsp;"; ?>

<? if ($count>0)
echo anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));?>
</div>


<script type="text/javascript" src="<?=base_url();?>assets/js/tooltip.js"></script>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>