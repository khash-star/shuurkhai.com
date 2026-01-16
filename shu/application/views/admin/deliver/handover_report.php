<div class="panel panel-primary">
  <div class="panel-heading">Хүргэлттэй ачаа</div>
  <div class="panel-body">

<? 
$xls_name = "handover.xlsx";
$xls2_name = "handover_offshore.xlsx";
$prev_id = 0;
$customer_weight=0;

require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');

$writer = new XLSXWriter();
$writer2 = new XLSXWriter();

$styles1 = array( 'font'=>'Arial','font-size'=>11,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center', 'border'=>'left,right,top,bottom');

$styles2 = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'regular', 'fill'=>'#fff', 'halign'=>'left', 'border'=>'bottom');

$sql="SELECT orders.*, receiver_customer.name AS r_name,receiver_customer.surname AS r_surname,receiver_customer.tel AS r_tel,receiver_customer.address AS r_address,receiver_customer.address_extra AS r_address_extra,sender_customer.name AS s_name,sender_customer.surname AS s_surname,sender_customer.tel AS s_tel,sender_customer.address AS s_address FROM orders LEFT JOIN customer AS receiver_customer ON orders.receiver=receiver_customer.customer_id 
LEFT JOIN customer AS sender_customer ON orders.sender=sender_customer.customer_id";
$sql.=" WHERE transport=1 AND orders.status IN('warehouse','onair')";

$sql_group="SELECT * FROM orders WHERE transport=1 AND orders.status IN('warehouse','onair') GROUP BY receiver";
$query = $this->db->query($sql_group);
$total_customer = $query->num_rows();

$sql.=" ORDER BY receiver,created_date DESC";

$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
     echo "<table class='table table-hover small'>";
	 echo "<tr>";
	   echo "<th>№</th>"; 
	   echo "<th>Хүлээн авагч</th>"; 
	   echo "<th>Barcode/Track</th>"; 
	  echo "<th></th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th>Жин</th>"; 
	   echo "<th>Төлбөр /Үлдэгдэл/</th>";
	   echo "<th>1$=".cfg_rate()."₮</th>"; 
	   echo "</tr>";
	   $count=1;$total_weight=0;$total_price=0;$c_count=1;
	   
	   $writer->writeSheetRow('Sheet1', array('Хүлээн авагч','Утас','Proxy','Barcode','Төлөв','Жин'), $styles1 );


	  $writer2->writeSheetRow('Sheet1', array('','','','Хүргэлтийн хуудас','','','',date("Y-m-d H:i"),''), $styles1 );


	   $writer2->writeSheetRow('Sheet1', array('','SHuurkhai.com','','','','Хүлээлгэн өгсөн: .......................',''), $styles1 );

	   $writer2->writeSheetRow('Sheet1', array('','90358585','','','','Хүлээн авсан: .......................'), $styles1 );
	   $writer2->writeSheetRow('Sheet1', array('','90358585','','','','Нийт хүлээн авагч: '.$total_customer.' харилцагч'), $styles1 );

	    $writer2->writeSheetRow('Sheet1', array(''), $styles2);
	    $writer2->writeSheetRow('Sheet1', array('№','Нэр овог','Утас','Хаяг','Тоо','Жин','$','₮','Гарын үсэг'), $styles1 );
	   //$writer2->writeSheetRow('Sheet1', array('Хүлээн авагч','Утас','Хаяг','Barcode','Төлөв','Жин','Төлбөр /$/','Төлбөр /₮/','Гарын үсэг'), $styles1 );


	foreach ($query->result() as $row)
	{  

		$created_date=$row->created_date;
		$order_id=$row->order_id;
		$weight=$row->weight;
		$price=$row->price;
		$sender_id=$row->s_name;
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
		$receiver_address_extra=$row->r_address_extra;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->package;
		$Package_advance = $row->advance;
		$Package_advance_value = $row->advance_value;
		$extra=$row->extra;
		$third_party=$row->third_party;
		$status=$row->status;
		$is_online=$row->is_online;
		$total_weight+=$weight;
		$total_price+=$Package_advance_value;
		$transport = $row->transport;
		$proxy = $row->proxy_id;
		$proxy_type = $row->proxy_type;
		$proxy_name=proxy2($proxy,$proxy_type,"full_name");
		$proxy_contact=proxy2($proxy,$proxy_type,"tel");
		$proxy_address=proxy2($proxy,$proxy_type,"address");
		
		if ($prev_id!=$receiver_id &&$prev_id!=0)
	  	{
		    // $customer_weight+=$weight;
			echo "<tr><td colspan='4'>Нийт<td><td>".$customer_weight."</td><td>".cfg_price($customer_weight)."$</td><td>".cfg_rate()*cfg_price($customer_weight)."₮</td><td></td></tr>";	
			
			//$count=1;
			$writer->writeSheetRow('Sheet1', array('Нийт','','','','',$customer_weight), $styles2 );
			//if ($status=="weight_missing" && $extra=="999") // 999-хүргэлтэнд гарсан
			$writer2->writeSheetRow('Sheet1', array($c_count++,customer($prev_id,"full_name"),customer($prev_id,"tel"),customer($prev_id,"address").customer($prev_id,"address_extra"),--$count,$customer_weight,cfg_price($customer_weight).'$',cfg_rate()*cfg_price($customer_weight)."₮"), $styles2 );

			$customer_weight=0;
			$count =1;
	   	}

	   
		$tr=0;
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
		
		if ($receiver_id!="" &&$status=='order'&&!$tr)
		{echo "<tr class='blue' title='Хүлээн авагч тодорхойгүй'>"; $tr=1;}
		
		if ($receiver_id!=1&&$status=='filled'&&!$tr)
		{echo "<tr class='green' title='Хүлээн авагч бөглөсөн'>"; $tr=1;}
		
		
	  	if ($Package_advance==1&&!$tr)
		{echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
		
		
		if($status!="warehouse") $temp_status=$status; 
		if($status=="warehouse"&&$extra!="999") $temp_status=$status." ".$extra."-р тавиур";
		if($status=="warehouse"&&$extra=="999") $temp_status="Хүргэлтэнд"; 

		if (!$tr) echo "<tr>";else $tr=0;
	    echo "<td>".$count."</td>"; 
		echo "<td>";
		echo anchor("admin/customers_detail/".$receiver_id,substr($receiver_surname,0,2).".".$receiver);
		 echo "/".anchor("admin/customers_detail/".$receiver_id,customer($receiver_id,"tel"))."/";
		 echo "<br>".customer($receiver_id,"address");
		  echo "<br>".customer($receiver_id,"address_extra");
		 if ($proxy_name!="")  
		 	{	echo "<br>p:".$proxy_name;
		   		echo "<br>pa:".$proxy_address;
		   	}
		 echo "</td>";

	   echo "<td>".barcode_comfort($barcode)."<br>"; 
	   echo $third_party."</td>"; 
	   echo "<td>";
	   if (!$is_online) echo "Илгээмж"; else echo "Онлайн";
	   echo "</td>"; 
	   echo "<td>".$temp_status."</td>";
	   echo "<td>".$weight."</td>"; 
	   echo "<td>".anchor('admin/orders_detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	   /*if ($prev_id!=0 && $prev_id!=$receiver_id)
		{
			//$prev_id=$receiver_id;
			$writer2->writeSheetRow('Sheet1', array(customer($prev_id,"full_name"),customer($prev_id,"tel"),customer($prev_id,"address").customer($prev_id,"address_extra"),$count,$customer_weight,cfg_price($customer_weight).'$',cfg_rate($customer_weight)."₮"), $styles2 );
		}
		*/

	  $prev_id=$receiver_id;

		if ($prev_id==$receiver_id)
	   { $customer_weight+=$weight;
	   	 $count++;
	   }
	    else $count=1;


		$writer->writeSheetRow('Sheet1', array($receiver_surname." ".$receiver,$receiver_contact,$proxy_name." ".$receiver,$barcode,$temp_status,floatval($weight)), $styles1 );

		if ($prev_id!=$receiver_id &&$prev_id!=0)
	  	{
		    
			$writer2->writeSheetRow('Sheet1', array($c_count++,customer($prev_id,"full_name"),customer($prev_id,"tel"),customer($prev_id,"address").customer($prev_id,"address_extra"),--$count,$customer_weight,cfg_price($customer_weight).'$',cfg_rate()*cfg_price($customer_weight)."₮"), $styles2 );
	   	}

		
	//if ($status=="warehouse"&&$extra=="999") $writer2->writeSheetRow('Sheet1', array($receiver_surname." ".$receiver,$receiver_contact,$proxy_name." ".$receiver,$barcode,$temp_status,floatval($weight)), $styles1 );

	//  array_push($data,array($sender_surname,$sender,$sender_contact,$sender_address,$receiver_surname,$receiver,$receiver_contact,$receiver_address.$receiver_address_extra,$barcode,strval(" ".$third_party),floatval($weight),floatval(cfg_price($weight)),floatval($Package_advance_value),$description));	
 	
	} 
	if ($prev_id!=0)
	$writer2->writeSheetRow('Sheet1', array($c_count++,customer($receiver_id,"full_name"),customer($receiver_id,"tel"),customer($receiver_id,"address").customer($receiver_id,"address_extra"),--$count,$customer_weight,cfg_price($customer_weight).'$',cfg_rate()*cfg_price($customer_weight)."₮"), $styles2 );

	echo "<tr><td colspan='4'>Нийт<td><td>".$customer_weight."</td><td>".cfg_price($customer_weight)."$</td><td>".cfg_rate($customer_weight)."₮</td><td></td></tr>";	
	
	 echo "<tr><td colspan='5'>Бүүр нийт</td><td>$total_weight</td><td>".$total_weight*cfg_paymentrate()."</td><td>$total_price</td><td></td></tr>";
	 echo "</table>";
	 
	 	$writer->writeSheetRow('Sheet1', array('Нийт','','','','',$customer_weight), $styles2 );
		$writer->writeSheetRow('Sheet1', array('Бүүр нийт','','','','',$total_weight), $styles2 );

		//$writer2->writeSheetRow('Sheet1', array(customer($receiver_id,"full_name"),'','','','',$customer_weight,'',''), $styles2 );
		$writer2->writeSheetRow('Sheet1', array('Нийт','','','','',$total_weight), $styles2 );

	// array_push($data,array('Нийт','','','','','','','','','',floatval($total_weight),floatval(cfg_rate($total_weight)),floatval($total_price)));

	//$writer = new XLSXWriter();
	//$writer->writeSheet($data, $styles1);
	$writer->writeToFile('assets/'.$xls_name);
	$writer2->writeToFile('assets/'.$xls2_name);
	
}
else echo "Илгээмж олдсонгүй";
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<!--div class='foot_follower'>
<?	
//if(!isset($total_weight)) $total_weight=0;

//echo "<b>Нийт</b>&nbsp;&nbsp;&nbsp;&nbsp;".$total_weight."Kg&nbsp;&nbsp;&nbsp;&nbsp;"; ?>

<? //anchor(base_url().'assets/'.$xls_name, 'Excel файл татах',array('class'=>'btn btn-warning'));?>
</div-->

<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>