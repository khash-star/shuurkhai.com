<script type="application/javascript">
	$(function() {
		$('input[name="receiver_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="receiver_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#receiver_result').append('<p id="responce">'+responce+'</p>');	
									$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="receiver_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="receiver_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="receiver_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="receiver_email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="receiver_address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
	})
</script>
<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Илгээмж</h3>";
if ($this->uri->segment(3)=="" && !isset($_POST["search"]))
 {
	echo form_open("orders/track");
	echo "<span class='formspan'>Илгээмж</span>";
 	echo form_input("search");
	echo form_submit("submit","хайх");
 	echo form_close();
 }
 else 
 {
if ($this->uri->segment(3)!="") $search=$this->uri->segment(3); else $search=$_POST["search"];
$query = $this->db->query("SELECT * FROM orders WHERE order_id='".$search."'");
if ($query->num_rows() == 0) 
$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$search."'");
if ($query->num_rows() == 0) 
$query = $this->db->query("SELECT * FROM orders WHERE third_party='".$search."'");
if ($query->num_rows() == 1)
{
   		$row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$package=$row->package;
		$description=$row->description;
		$insurance=$row->insurance;
		$insurance_value=$row->insurance_value;
		$status=$row->status;
   
   echo "<h3>$barcode</h3>";
   echo $status."<br>";
   switch($status)
	   {	case "new": echo "<img src=\"".base_url()."assets/progress20.jpg\" width=\"700\"><br>";break;
	   		case "warehouse": echo "<img src=\"".base_url()."assets/progress95.jpg\" width=\"700\"><br>";break;
			case "delivered": echo "<img src=\"".base_url()."assets/progress100.jpg\" width=\"700\"><br>";break;
			case "onair": echo "<img src=\"".base_url()."assets/progress65.jpg\" width=\"700\"><br>";break;		
			case "custom": echo "<img src=\"".base_url()."assets/progress75.jpg\" width=\"700\"><br>";break;
			case "order": echo "<img src=\"".base_url()."assets/progress0.jpg\" width=\"700\"><br>";break;
	   }
	if ($status=="order" && $receiver==1)
	{
	echo "<div class=\"box\">";
	echo form_open('orders/track_filling');
	echo form_hidden("order_id",$order_id);
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "<span class='formspan'>Утас:</span>";
	echo form_input ("receiver_contact")."<div id=\"receiver_result\"></div><br>";
	echo "<span class='formspan'>РД:</span>";
	echo form_input ("receiver_rd")."";
	echo "<span class='formspan'>Овог:</span>";
	echo form_input ("receiver_surname")."";
	echo "<span class='formspan'>Нэр:</span>";
	echo form_input ("receiver_name")."<br>";
	echo "<span class='formspan'>И-мейл:</span>";
	echo form_input ("receiver_email")."<br>";
	echo "<span class='formspan'>Хаяг:</span>";
	echo form_textarea("receiver_address")."<br>";
	echo form_submit("submit","нэмэх");
	echo form_close();
	echo "</div>";
	}
   }
   else echo "Илгээмж олдсонгүй<br>";
 }

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('orders', 'Илгээмжүүд').'</li>
<li>'.anchor('orders/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->