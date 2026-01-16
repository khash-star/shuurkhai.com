<? if ($this->uri->segment(3)) $receiver_id=$this->uri->segment(3); else $receiver_id="";?>

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
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Online Илгээмж</h3>";
	echo form_open('online_orders/online_creating');
	if ($receiver_id!="")
	{
	echo "<div class=\"box\">";
	$query_reciever = $this->db->query("SELECT * FROM customer WHERE customer_id=\"$receiver_id\" LIMIT 1");
		foreach ($query_reciever->result() as $row_reciever)
		{
			$reciever_name=$row_reciever->name;
			$reciever_surname=$row_reciever->surname;
			$reciever_address=$row_reciever->address;
			$reciever_rd=$row_reciever->rd;
			$reciever_contact=$row_reciever->tel;
		}
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "Хүлээн авагч: ".substr($reciever_surname,0,2).".".$reciever_name."<br>";
	echo anchor ("online_orders/online_create","Өөр хүлээн авагч");
	echo "</div>";
	}
	else 
	{
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "<span class='formspan'>Утас:</span>";
	echo form_input ("receiver_contact")."<div id=\"receiver_result\"></div><br>";
	echo "<span class='formspan'>Нэр:</span>";
	echo form_input ("receiver_name")."";
	echo "<span class='formspan'>Овог:</span>";
	echo form_input ("receiver_surname")."";
	echo "<span class='formspan'>РД:</span>";
	echo form_input ("receiver_rd")."<br>";
	echo "<span class='formspan'>И-мейл:</span>";
	echo form_input ("receiver_email")."<br>";
	echo "<span class='formspan'>Хаяг:</span>";
	echo form_textarea("receiver_address")."<br>";
	echo "</div>";
	}
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "<span class='formspan'>Веблинк:</span>";
	echo form_textarea("online_url")."<br>";
	echo "<span class='formspan'>Тоо ширхэг:</span>";
	echo form_input ("online_number");
	echo "<span class='formspan'>Размер:</span>";
	echo form_input ("online_size");
	echo "<span class='formspan'>Өнгө:</span>";
	echo form_input ("online_color");
	
	echo "</div>";
	echo form_submit("submit","нэмэх");
	echo form_close();

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('online_orders', 'Илгээмжүүд').'</li>
<li>'.anchor('online_orders/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->