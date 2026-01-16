<? if ($this->uri->segment(3)) $type=$this->uri->segment(3); else $type=""; ?>


<div class="panel panel-success">
  <div class="panel-heading">Box-д ороогүй илгээмжүүд
   <span title="Хайрцаглагдаагүй бэлэн ачаа">(<?=anchor("agents/boxes_outside/orders",agent_boxed_order());?> new order</span>
  <span title="Хайрцаглагдаагүй бэлэн нэгтгэсэн ачаа">,<?=anchor("agents/boxes_outside/combine",agent_boxed_combine());?> new combine)</span>
  </div>
  <div class="panel-body">
<? 
if ($type=="") $type="orders";
if ( $type=="orders" || $type=="")
{
	$sql="SELECT * FROM orders WHERE boxed=0 AND status='new' ORDER BY created_date DESC";
	
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
		   echo "<th>Хүлээн авагч</th>"; 
		   echo "<th>Хүлээн авагчын утас</th>"; 
		   echo "<th>Barcode</th>"; 
		   echo "<th>Хоног</th>"; 
		   echo "<th>Төлөв</th>"; 
		   echo "<th>Жин</th>"; 
		   echo "<th>Төлбөр</th>";
		   echo "<th>Үлдэгдэл</th>";
		   echo "<th></th>"; 
		   echo "</tr>";
		   $count=1;$total_weight=0;$total_price=0;
	
		foreach ($query->result() as $row)
		{  
			$created_date=$row->created_date;
			$order_id=$row->order_id;
			$weight=$row->weight;
			$price=$row->price;
			$sender_id=$row->sender;
			$sender_name=customer($sender_id,"full_name");
			//$sender_surname=$row->s_surname;
			$sender_contact=customer($sender_id,"contact");
			//$sender_address=$row->s_address;
			//$receiver=$row->r_name;
			$receiver_id=$row->receiver;
			$receiver_name=customer($receiver_id,"full_name");
			$receiver_contact=customer($receiver_id,"tel");
	
			$barcode=$row->barcode;
			$package=$row->package;
			$description=$row->package;
			$Package_advance = $row->advance;
			$Package_advance_value = $row->advance_value;
			$extra=$row->extra;
			$status=$row->status;
			$total_weight+=intval($weight);
			$total_price+=intval($Package_advance_value);
			$tr=0;
			$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;		
			
			if ($Package_advance==1&&!$tr)
			{echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; $tr=1;}
			
			if($status=="warehouse"&&$extra!="") $temp_status=$status." ".$extra."-р тавиур";else $temp_status=$status; 
			if (!$tr) echo "<tr>";else $tr=0;
		   //echo "<td>".form_checkbox("orders[]",$order_id)."</td>"; 
		   echo "<td>".$count++."</td>"; 
		   echo "<td>".$created_date."</td>"; 
			//echo "<td>".anchor("agents/customers_detail/".$sender_id,$sender_name)."</td>";
			echo "<td>".anchor("agents/customers_detail/".$receiver_id,$receiver_name)."</td>";
		   echo "<td>".$receiver_contact."</td>"; 
		   echo "<td>".$barcode."</td>"; 
		   echo "<td>".$days."</td>"; 
		   echo "<td>".$temp_status."</td>";
		   echo "<td>".$weight."</td>"; 
		   echo "<td>".$weight*cfg_paymentrate()."</td>"; 
		   echo "<td>".$Package_advance_value."</td>"; 
			
		   echo "<td>".anchor('agents/detail/'.$row->order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
		   echo "</tr>";
	 
	
		} 
		 
		 
		echo "</table>";
	}
}


if ( $type=="combine"|| $type=="")
{
	$sql="SELECT * FROM box_combine WHERE status='new' AND boxed=0";
	$query = $this->db->query($sql);
	if ($query->num_rows() > 0)
	{
		echo "<table class='table table-hover'>";
		 echo "<tr>";
		   echo "<th>№</th>"; 
		   echo "<th>Barcode</th>"; 
		   echo "<th>Х/aвагч</th>"; 
		   echo "<th>Огноо</th>"; 
		   echo "<th>Төлөв</th>"; 
		   echo "<th>Kg</th>"; 
		   echo "<th></th>"; 
		   echo "</tr>";
		   $count=1;
		   $total_weight=0;
		   $cumulative_weight=0;
		   $cumulative_packages = 0;
		foreach ($query->result() as $row)
		{ 
			$receiver= $row->receiver; 
			$weight= $row->weight;
			$created_date = $row->created_date;
			$barcode = $row->barcode;
			$barcodes = $row->barcodes;
			$proxy_id = $row->proxy_id;
			$status = $row->status;
			$total_weight+=$weight;
		
		   echo "<tr>";
		   echo "<td>".$count++."</td>";
		    echo "<td>".$barcode."</td>";
		   echo "<td>".customer($receiver,"name");
		   echo customer($receiver,"tel");
		   echo "</td>"; 
		   echo "<td>".$created_date."</td>"; 
		   echo "<td>".$status."</td>"; 
		   echo "<td>".$weight."</td>"; 
	
		   echo "<td>";
		   if ($status!="warehouse" && $status!="delivered" && $status!="onair")
		   echo anchor('agents/combine_delete/'.$row->combine_id,'<span class="glyphicon glyphicon-trash"></span>');
		   echo anchor('agents/combine_display/'.$row->combine_id,'<span class="glyphicon glyphicon-edit"></span>');
		   echo "</td>"; 
		   echo "</tr>";
	
		} 
		//echo "<tr><td></td><td colspan='2'>Нийт</td><td>$cumulative_packages</td><td></td><td></td><td>$cumulative_weight</td><td></td></tr>";
	
		echo "</table>";
		
	}
	else echo '<div class="alert alert-danger" role="alert">No combines</div>';
}

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>