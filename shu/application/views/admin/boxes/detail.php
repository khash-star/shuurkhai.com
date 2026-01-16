<? if (!$this->uri->segment(3)) redirect('agents/boxes'); else $box_id=$this->uri->segment(3) ?>


<div class="panel panel-primary">
  <div class="panel-heading">Box Related Settings</div>
  <div class="panel-body">
<? 
require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');


$query_box=$this->db->query("SELECT * FROM boxes WHERE box_id=".$box_id);
$box_row=$query_box->row();
// $box_row->name;
echo "<h3>Inside Box №$box_row->name</h3>";

$query = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=".$box_id);
$total_weight=0;
if ($query->num_rows() > 0)
{
	 $query_box=$this->db->query("SELECT * FROM boxes WHERE box_id=".$box_id);
	 $box_row=$query_box->row();
	 
	 $data =array(array("","Box:".$box_row->name,"","","","","","Date:".$box_row->created_date));
	 array_push($data,array("","","","","","","",""));
	 array_push($data,array('№','Barcode','Proxy surname','Proxy name','Proxy tel','Proxy Address','KG','Packaged'));
		
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th></th>"; 
	  	echo "<th>Barcode</th>"; 
		echo "<th>Receiver</th>"; 
		echo "<th>Contact</th>"; 
		echo "<th>Kg</th>"; 
		echo "<th>Status</th>"; 
	  	echo "</tr>";
	 	$count=1;
	foreach ($query->result() as $row)
	{ 
	   $barcode=$row->barcode;
	   $weight=$row->weight;
	   $combine=$row->combined;
	   $order_id=$row->order_id;
	   if ($order_id!=0)
	   {
	   $query_order = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
	   if ($query_order->num_rows()==1)
	   	{
		$query_order=$query_order->row();
	   $status=$query_order->status;
	   $receiver = $query_order->receiver;
	   $proxy= $query_order->proxy_id;
	   $proxy_type= $query_order->proxy_type;
		}
		else $status=$receiver=$proxy="";
	   }
	   else 
	   {
	   $query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."'");
	    if ($query_combine->num_rows()==1)
	   	{
	   $combine_row=$query_combine->row();
	   $status=$combine_row->status;
	   $receiver = $combine_row->receiver;
	   $proxy= $combine_row->proxy_id;
	   $proxy_type= $combine_row->proxy_type;
		}
		else  $status=$receiver=$proxy="";
		}
	   

	   //$query_order = $this->db->query("SELECT * FROM customer WHERE customer_id=".$receiver_id);
	  // $receiver_row=$query_order->row();
	   $r_name= customer($receiver,"name");
	   $r_surname= customer($receiver,"surname");
	   $r_tel= customer($receiver,"tel");
	   $r_address= customer($receiver,"address");
	  	  
	   echo "<tr>";
	   echo "<td>".$count."</td>";
	   echo "<td>".barcode_comfort($barcode)."</td>";
	   echo "<td>"; 
	   if($r_name!="") echo anchor("admin/customers_detail/".$receiver,substr($r_surname,0,2).".".$r_name);
	   if ($proxy>0) echo "<br>".$proxy.":".proxy2($proxy,$proxy_type,"name");
	   echo "</td>";
	   echo "<td>".$r_tel."</td>";
	   echo "<td>".$weight."</td>";
	   echo "<td>".$status."</td>";
	   echo "</tr>";
	   $total_weight+=$weight;
	   if ($proxy>0)
	   $data_single = array ($count,$barcode,proxy2($proxy,$proxy_type,"surname"),proxy2($proxy,$proxy_type,"name"),proxy2($proxy,$proxy_type,"tel"),proxy2($proxy,$proxy_type,"address"),$weight,$combine);
	   else 
	   $data_single = array ($count,$barcode,$r_surname,$r_name,$r_tel,$r_address,$weight,$combine);
		
	   array_push($data,$data_single);
	   $count++;


	
   }
   		echo "<tr>";
	   echo "<td colspan='4'>Нийт</td>";
	   echo "<td>".$total_weight."</td>";
	   echo "<td></td>";
	   echo "</tr>";

    echo "</table>";
		array_push($data,array("","","","","","",$total_weight,""));
        $writer = new XLSXWriter();
	   $writer->writeSheet($data);
	   $writer->writeToFile('assets/boxes.xlsx');
	
}
   else echo "Nothing inside Box<br>";

?>

</div>
</div>
<?=anchor(base_url().'assets/boxes.xlsx', 'Excel файл татах',array('class'=>'btn btn-warning'));?>



<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>