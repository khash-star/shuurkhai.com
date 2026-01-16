<style>
table {margin-top:20px; margin-bottom:20px;}
</style>

<script>
$(document).ready(function() {
    $('input[name="select_all"]').click(function(event) {
        if(this.checked) { 
            $('input[type="checkbox"]').each(function() {
                this.checked = true;            
            });
        }else{
            $('input[type="checkbox"]').each(function() {
                this.checked = false; 
            });        
        }
    });
})
</script>
<div class="panel panel-success">
  <div class="panel-heading">Нэхэмжлэх</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM orders WHERE receiver=".$customer_id." AND status NOT IN('delivered','completed','order','weight_missing') AND created_date>'2015-09-01' ORDER BY created_date DESC";

$query = $this->db->query($sql);
if ($query->num_rows() > 0)
{
	echo form_open("customer/envoice_display",array("target"=>"new"));
	echo "<p style='float:left'>Хэвлэх нэхэмжлэхийн урд <span class='glyphicon glyphicon-ok'></span> тэмдэглэнэ үү.</p>";
	echo form_submit("submit","Хэвлэх",array("class"=>"btn btn-warning  btn-sm","style"=>"float:right;margin-bottom:10px"))."<span class=\"glyphicon glyphicon-print\" style='float:right'></span>";

	echo "<table class='table table-hover'>";
	echo "<tr><th>".form_checkbox(array('name'=>'select_all','title'=>'Select all orders','checked'=>'checked'))."</th><th>№</th><th width='90'>Огноо</th><th>Barcode</th><th>Track</th><th>Жин</th><th>Төлөв</th><th>Үйлдэл</th></tr>";
	$i=$query->num_rows();
	foreach ($query->result() as $row)
	{  
	$order_id=$row->order_id;
	$weight=$row->weight;
	$price=$row->price;
	
	
	$created_date=$row->created_date;
	$onair_date=$row->onair_date;
	$warehouse_date=$row->warehouse_date;
	$delivered_date=$row->delivered_date;
	
	
	$barcode=$row->barcode;
	$package=$row->package;
	$price=$row->price;
	
	$sender=$row->sender;
	$receiver=$row->receiver;
	$deliver=$row->deliver;
	
	$insurance=$row->insurance;
	$insurance_value=$row->insurance_value;
	$advance=$row->advance;
	$advance_value=$row->advance_value;
	$third_party=$row->third_party;
	
	$way=$row->way;
	$deliver_time=$row->deliver_time;
	$inside=$row->inside;
	$return_type=$row->return_type;
	$return_day=$row->return_day;
	$return_way=$row->return_way;
	$return_address=$row->return_address;
	
	$extra=$row->extra;
	$timestamp=$row->timestamp;
	$status=$row->status;
	$agents=$row->agents;
	$is_online=$row->is_online;
	
	
	$package_array=explode("##",$package);
   	$package1_name = $package_array[0];
	$package1_num = $package_array[1];
	$package1_value = $package_array[2];
	$package2_name = $package_array[3];
	$package2_num = $package_array[4];
	$package2_value = $package_array[5];
	$package3_name = $package_array[6];
	$package3_num = $package_array[7];
	$package3_value = $package_array[8];
	$package4_name = $package_array[9];
	$package4_num = $package_array[10];
	$package4_value = $package_array[11];
		
	
	echo "<tr>";
	echo "<td>".form_checkbox("orders[]",$order_id,array('checked'=>'checked'))."</td>";
	echo "<td>".$i--."</td>";
	echo "<td>";
	echo substr($created_date,0,10);
	if ($delivered_date !="0000-00-00 00:00:00") echo "<br>Ирсэн:<br><span style='color:#F00'>".substr($delivered_date,0,10)."</span>";
	echo "</td>";

	
	echo "<td>".anchor("customer/orders_detail/".$order_id,$barcode)."</td>";
	echo "<td>";
	if ($third_party!="")
	echo "<a href='".track($third_party)."' target='_blank' title='Хаана явна'>$third_party<span class='glyphicon glyphicon-globe'></span></a>";
	if ($package1_name!="")
	echo "<br>$package1_name ($package1_num)";
	if ($package2_name!="")
	echo "<br>$package2_name ($package2_num)";
	if ($package3_name!="")
	echo "<br>$package3_name ($package3_num)";
	if ($package4_name!="")
	echo "<br>$package4_name ($package4_num)";
	echo "</td>";
	echo "<td>".$weight."</td>";	
	echo "<td>".status_comfort($status)." </td>";
	echo "<td>";
	echo anchor("customer/orders_detail/".$order_id,"Дэлгэрэнгүй",array("class"=>"btn btn-xs btn-success"));

	//if ($status=="weight_missing") echo anchor("customer/orders_deleting/".$online_id,"Устгах",array("class"=>"btn btn-xs btn-danger"));
	echo "</td>";
	echo "</tr>";	
	}
	echo "</table>";
	echo form_submit("submit","Хэвлэх",array("class"=>"btn btn-warning  btn-sm","style"=>"float:right;margin-bottom:10px"))."<span class=\"glyphicon glyphicon-print\" style='float:right'></span>";
	echo form_close();
}
else //$query->num_rows() ==0
{
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
}
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>


<script language="javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>