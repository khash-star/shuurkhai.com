<? if (!$this->uri->segment(3)) redirect('orders/display'); else $order_id=$this->uri->segment(3) ?>
<script src="<?=base_url();?>assets/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery-ui.css"/>
<script>
$(document).ready(function() {
	$("span#delete_button").click(function(){
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:400,
		modal: true,
		buttons: 
		{
			
			"Үгүй": function() {
			$( this ).dialog( "close" );
			},
	
			"Тийм": function() {
			$( this ).dialog( "close" );
			window.location="<?=base_url()?>index.php/orders/deleting/<?=$order_id?>";
			}
		}
	});
	});
});
</script>
<div id="dialog-confirm" title="Илгээмж устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Энэ захиалгыг устгах уу?</p>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
   $row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$package=$row->package;
		//$description=$row->description;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$status=$row->status;
   
   		//SENDER 
		$query_sender = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$sender\" LIMIT 1");
		foreach ($query_sender->result() as $row_sender)
		{
			$sender_name=$row_sender->name;

		}
		
		//RECIEVER
		$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver\" LIMIT 1");
		foreach ($query_reciever->result() as $row_reciever)
		{
			$reciever_name=$row_reciever->name;
			$reciever_contact=$row_reciever->tel;
		}
   
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
	
   
   
    echo "<table class='table table-hover'>";
    echo "<tr><td>Илгээмжийн огноо</td><td>".$created_date."</td></tr>";
    echo "<tr><td>Илгээгч</td><td>".$sender_name."</td></tr>"; 
    echo "<tr><td>Хүлээн авагч</td><td>".$reciever_name."</td></tr>" ;
	echo "<tr><td>Хүлээн авагчын утас</td><td>".$reciever_contact."</td></tr>" ;
    echo "<tr><td>Barcode</td><td>".$barcode."</td></tr>" ;
	echo "<tr><td>Илгээмж</td><td>".$package1_name.",".$package2_name.",".$package3_name.",".$package4_name."</td></tr>" ;
	echo "<tr><td>Даатгал</td><td>".$insurance."</td></tr>" ;
	//echo "<tr><td>Тайлбар</td><td>".$description."</td></tr>";
	echo "</table>";
	
   		//echo "<h3>Илгээмж устгах</h3>";
		/*echo form_open('');
		echo form_hidden('order_id',$order_id);
		echo "<span>Шалтгаан:</span>";
		echo form_textarea("log","Алдаатай оруулсан")."<br>";
		echo form_submit("submit","устгах");
		echo form_close();*/
	
	

    echo "<span id='delete_button'>Устгах</a><br>";

   }
   else echo "Илгээмж олдсонгүй олдсонгүй<br>";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->