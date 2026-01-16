<? 
if(isset($_POST["search"])) 
	{
	$search_term=str_replace(" ","%",$_POST["search"]);
	if ($search_term!="")
	echo "Xайлт:".$search_term."<br>";
	}
	else $search_term="";
if (isset($_POST["type"])) $type=$_POST["type"]; else $type='all';

if(isset($_POST["start_date"])) 
$start_date = date("Y-m-d", strtotime($_POST["start_date"]))." 00:00:00";
else $start_date = date("Y-m-d")." 00:00:00";

if(isset($_POST["finish_date"])) 
$finish_date = date("Y-m-d", strtotime($_POST["finish_date"]))." 23:59:00";
else $finish_date = date("Y-m-d")." 23:59:00";


//echo "<h3>Идэвхитэй захиалгууд</h3>";
$sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
$sql.=" WHERE CONCAT_WS(receiver_customer.name,receiver_customer.tel,sender_customer.name,orders.barcode,orders.third_party) LIKE '%".$search_term."%'";

$sql.=" AND orders.status IN ('delivered','custom')";
if ($type=="advance") $sql.=" AND orders.advance =1";

if ($start_date!="")  $sql.=" AND delivered_date>'$start_date'";
if ($finish_date!="")  $sql.=" AND delivered_date<'$finish_date'";

$sql.=" ORDER BY delivered_date DESC";

//echo $sql;



//if(isset($_POST["search"])) 
//$sql.=" AND CONCAT_WS(barcode,package,senders.name,senders.tel,receivers.name,receivers.tel,created_date) LIKE '%".$search_term."%'";
//$sql.=" ORDER BY created_date DESC";
//echo $sql;
$query = $this->db->query($sql);

//$query = $this->db->like("barcode","CP87");
if ($query->num_rows() > 0)
{
	//echo form_open("deliver/deliver_multiple");
     echo "<table class='table table-hover'>";
	 echo "<tr>";
	  // echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders'))."</th>";
	   echo "<th>№</th>"; 
	   echo "<th>Үүсгэсэн огноо</th>"; 
	   echo "<th>Олгосон огноо</th>"; 
	   echo "<th>Х/авагч</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th>Гардаж авсан</th>"; 
	   echo "<th>Утас</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Track</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр</th>"; 
	   echo "<th>Үлдэгдэл</th>";
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_advance=0;
	foreach ($query->result() as $row)
	{  
		$created_date=$row->created_date;
		$delivered_date=$row->delivered_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
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
		$deliver_id=$row->deliver;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->package;
		$extra=$row->extra;
		$third_party=$row->third_party;
		$status=$row->status;
		
		$weight=$row->weight;
		$advance=$row->advance;
		$advance_value=$row->advance_value;
		
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
		
	  	if ($advance==1&&!$tr)
		{echo "<tr class=\"red\" title=\"Үлдэгдэл:".$advance_value."$\">"; $tr=1;}
		
		if (!$tr) echo "<tr>";else $tr=0;
	  // echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
	   echo "<td>".$count++."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>".$delivered_date."</td>"; 
       //echo "<td>".$sender."</td>"; 
	   //echo "<td>".$receiver."</td>";
	   //echo "<td>"; if($sender!="") echo anchor("customers/detail/".$sender_id,$sender); echo "</td>"; 
	   echo "<td>"; if($receiver!="") echo anchor("customers/detail/".$receiver_id,$receiver); echo "</td>";
	   echo "<td>".$receiver_contact."</td>"; 
	   if ($status=='custom')
	   echo "<td colspan='2'>Гаальд саатсан</td>";
	   if ($status!='custom')
	   {
	   echo "<td>"; if($deliver_id!="" && costumer($deliver_id,"name")!="") echo anchor("customers/detail/".$deliver_id,costumer($deliver_id,"name")); echo "</td>";
	   
	   echo "<td>"; if($deliver_id!="" &&  costumer($deliver_id,"tel")!="") echo costumer($deliver_id,"tel"); echo "</td>";
	   }
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$third_party."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>".$weight."</td>"; 
	   echo "<td>".$weight*cfg_paymentrate()."</td>"; 
	   echo "<td>".$advance_value."</td>"; 
	   echo "<td>".anchor('orders/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
		$total_advance += $advance_value;
		$total_weight += $weight;


	} 
	echo "<tr class='total'><td colspan='10'>Нийт</td><td>$total_weight</td><td>".$total_weight*cfg_paymentrate()."</td><td>$total_advance</td><td></td></tr>";
	echo "</table>";
	
	//echo form_submit("submit","Олгох");
	//echo form_close();
}
else echo "Илгээмж олдсонгүй<br>";


?>