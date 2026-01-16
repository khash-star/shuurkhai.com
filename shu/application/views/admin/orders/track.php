<script>
jQuery(function($){
	//	$("input[name='receiver_rd']").mask("аа99999999");
   		//$("input[name='receiver_contact']").mask("99999999?99");
		//$("input[name='receiver_name']").mask("өө?өөөөөөөөөөөөөөөөөөөөөө");
		//$("input[name='receiver_surname']").mask("өө?өөөөөөөөөөөөөөөөөөөөөө");
		//$("input[name='receiver_email']").mask("*");
})
</script>

<script type="application/javascript">
	$(function() {
		$('body').on('keydown', 'input, select, textarea', function(e) {
			var self = $(this)
			  , form = self.parents('form:eq(0)')
			  , focusable
			  , next
			  ;
			if (e.keyCode == 13) {
				focusable = form.find('input,a,select,button,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				if (next.length) {
					next.focus();
				} else {
					form.submit();
				}
				return false;
			}
		});
		
		
		$('input[name="receiver_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="receiver_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									//$('#responce').remove();
									//$('#receiver_result').append('<p id="responce">'+responce+'</p>');	
									//$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="receiver_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="receiver_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="receiver_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="receiver_email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
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
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<?
//echo "<a href='http://americanmongols.com/index.php?option=com_content&view=article&id=35&Itemid=115' target='new'><img src='".base_url()."assets/online_shops.jpg' title='АНУ дахь онлайн худалдааны сайтууд'></a><br>";
?>
<? 
if ($this->uri->segment(3)=="" && !isset($_POST["search"]))
 {
	echo form_open("orders/track");
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Find Order</h4>";
	echo "<span class='formspan'>Track or Barcode</span>";
	echo "<input type='text' autofocus='autofocus' required='required' name='search'>";
 	//echo form_input(array('name'../../orders/=>'search','autofocus'../../orders/=>'autofocus','require'../../orders/=>'require'));
	echo form_submit("submit","хайх");
 	echo form_close();
	echo "</div>";
 }
 else 
 {
	if ($this->uri->segment(3)!="") $search=$this->uri->segment(3); else $search=$_POST["search"];
	if (substr($search,0,2)=='CP' || substr($search,0,2)=='GO') 
	$query = $this->db->query("SELECT * FROM orders WHERE barcode='".$search."' LIMIT 1");
	else $query = $this->db->query("SELECT * FROM orders WHERE SUBSTRING(third_party,-7,7) = '".substr($search,-7,7)."' LIMIT 1");

if ($query->num_rows() == 1)
{
   		$row = $query->row();
   		$created_date=$row->created_date;
		$order_id=$row->order_id;
  	 	$sender=$row->sender;
   		$receiver=$row->receiver;
		$barcode=$row->barcode;
		$sender=$row->sender;
		$third_party=$row->third_party;
		$status=$row->status;
   
   echo "<h3>$barcode</h3>";
  // echo $status."<br>";
   switch($status)
	   {	case "new": echo "<img src=\"".base_url()."assets/progress20.jpg\" width=\"700\"><br>";echo "Америкаас гараагүй байна";break;
	   		case "warehouse": echo "<img src=\"".base_url()."assets/progress95.jpg\" width=\"700\"><br>";echo "Улаанбаатарын салбарт ирсэн байна. Та бичиг баримттайгаа ирж авна уу.";break;
			case "delivered": echo "<img src=\"".base_url()."assets/progress100.jpg\" width=\"700\"><br>";echo "Илгээмжийг хүргэсэн.";break;
			case "onair": echo "<img src=\"".base_url()."assets/progress65.jpg\" width=\"700\"><br>";echo "Илгээмж Америкаас Монголруу гарсан";break;		
			case "custom": echo "<img src=\"".base_url()."assets/progress75.jpg\" width=\"700\"><br>";break;
			case "order": echo "<img src=\"".base_url()."assets/progress0.jpg\" width=\"700\"><br>";echo "Захиалга тань АНУ-дахь оффист ирсэн байна.<br> Мэдээллээ бүрэн оруулснаар АНУ-с гарах боломжтой.";break;
			case "filled": echo "<img src=\"".base_url()."assets/progress20.jpg\" width=\"700\"><br>";echo "Хүлээн авагчийн мэдээлэл бөглөгдсөн байна.Тун удахгүй гарна.";break;
			case "weight_missing": echo "<img src=\"".base_url()."assets/progress0.jpg\" width=\"700\"><br>";echo "Америкт дахь салбарт хүргэгдээгүй байна";break;
	   }
	if ($status=="order" && $receiver =1)
	{
	//echo "<ul class='information'>";
	//echo "<li>Нэр, овог, хаягийг зөвхөн крилл үсгээр оруулна.</li>";
	//echo "<li>Бүх талбарыг бөглөнө.</li>";
	//echo "</ul>";
		
	echo form_open('orders/track_filling');
	echo form_hidden("order_id",$order_id);
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "<span class='formspan'>Утас:</span>";
	echo "<input type='text' name='receiver_contact' required='required'  oninvalid='this.setCustomValidity(\"Утасны дугаарыг заавал оруулна\")'><br>";
	echo "<div id=\"receiver_result\"></div><br>";
	echo "<span class='formspan'>Нэр:</span>";
	echo "<input type='text' name='receiver_name' required='required' required oninvalid='this.setCustomValidity(\"Нэрээ заавал оруулна\")'>";
	echo "<span class='formspan'>Овог:</span>";
	echo "<input type='text' name='receiver_surname' required='required' required oninvalid='this.setCustomValidity(\"Овгийг заавал оруулна\")'>";
	echo "<span class='formspan'>РД:</span>";
	echo "<input type='text' name='receiver_rd' required='required' oninvalid='this.setCustomValidity(\"Регистрын дугаар заавал оруулна\")'><br>";
	echo "<span class='formspan'>И-мейл:</span>";
	echo "<input type='text' name='receiver_email' required='required' required><br>";
	echo "<span class='formspan'>Хаяг:</span>";
	echo "<textarea name='receiver_address' required='required' required oninvalid='this.setCustomValidity(\"Хаяг заавал оруулна\")'> </textarea><br>";

	//echo form_textarea("receiver_address")."<br>";
	echo "</div>";
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "<span class='formspan'>Барааны нэр:</span>";
	echo "<input type='text' required='required' name='package' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>";
	echo "<span class='formspan'>Үнэ:</span>"; 
	echo "<input type='text' required='required' name='price' required oninvalid='this.setCustomValidity(\"Барааны тухай заавал оруулна\")'>";
	echo "</div>";

	echo form_submit("submit","бүртгэх");
	echo form_close();
	
	}
   }
   else 
   	{
		//echo "Илгээмж олдсонгүй<br>";
		redirect("orders/track_register/".$search,'refresh',0);
	}
   
 }

?>



<div id="home">
<? $this->load->view("home_content");?>
</div>


</div>
<div id="right_side">
<? $this->load->view("left_content");?>
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