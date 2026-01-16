<? if (!$this->uri->segment(3)) redirect('agents/boxes'); else $box_id=$this->uri->segment(3) ?>


<div class="panel panel-success">
  <div class="panel-heading">Box доторхи</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$total_weight=0;
$query = $this->db->query("SELECT * FROM boxes_packages WHERE box_id=".$box_id);
$query_box=$this->db->query("SELECT * FROM boxes WHERE box_id=".$box_id);
if ($query_box->num_rows()==1)
{
	$row_box = $query_box->row();
	$box_name= 	$row_box ->name;
	$box_packages= 	$row_box ->packages;
	$box_weight= 	$row_box ->weight;
	$box_created= 	$row_box ->created_date;
	$box_status= 	$row_box ->status;
	echo "<b>".$box_name."</b><br>";
	echo "Үүсгэсэн огноо:".$box_created."<br>";
	echo "Төлөв:".$box_status."<br>";

}
if ($query->num_rows() > 0)
{	 
	 //$data =array(array("","Box:".$box_row->name,"","Date:".$box_row->created_date,""),array("","","","",""),
	// array('№','Barcode','Receiver','Contact'));
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<th></th>"; 
	  	echo "<th>Barcode</th>"; 
		echo "<th>Receiver</th>"; 
		echo "<th>Contact</th>"; 
		echo "<th>Kg</th>"; 
		echo "<th>Үйлдэл</th>"; 
	  	echo "</tr>";
	 	$count=1;
	foreach ($query->result() as $row)
	{ 
	   $barcode=$row->barcode;
	   $combined=$row->combined;
	   $barcodes=$row->barcodes;
	   $order_id=$row->order_id;
	   $weight=$row->weight;
	   $receiver=$row->receiver;
	  
	   echo "<tr>";
	   echo "<td>".$count++."</td>";
	   echo "<td>".barcode_comfort($barcode)."</td>";
	   
	   if ($combined==0)
	   {
	   $query_order = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
	   if ($query_order->num_rows()==1)
	   	{
		   	$row_order=$query_order->row();
		  // $status=$query_order->status;
		  	$receiver = $row_order->receiver;
		   	$proxy= $row_order->proxy_id;
		   	$proxy_type= $row_order->proxy_type;
	   	}
	   	else $proxy="";
	   }
	   if ($combined==1)
	   {
	   $query_combine = $this->db->query("SELECT * FROM box_combine WHERE barcode='".$barcode."'");
	   if ($query_combine->num_rows()==1)
	   	{
		   	$combine_row=$query_combine->row();
		  // $status=$combine_row->status;
		   	$receiver = $combine_row->receiver;
		   	$proxy= $combine_row->proxy_id;
		   	$proxy_type= $row_order->proxy_type;
	   	}
	   	else $proxy="";
		}
	   echo "<td>".customer($receiver,"full_name");echo "<br>";
	   if ($proxy!="") echo proxy2($proxy,"name",$proxy_type);"</td>";
	   echo "<td>".customer($receiver,"tel")."</td>";
	   echo "<td>".$weight."</td>";
	   $box_weight+=$weight;
	   echo "<td>".anchor("agents/boxes_removing/".$barcode,"гаргах",array("class"=>"btn btn-alert btn-xs"))."</td>";
	   echo "</tr>";
	}
    echo "</table>";
		echo "Нийт ачааны тоо:".$box_packages."&nbsp;&nbsp;&nbsp;Нийт жин:".$box_weight." Кg<br>";
}
   else echo "Nothing inside Box<br>";

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>