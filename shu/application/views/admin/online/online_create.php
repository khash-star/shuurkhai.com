<? if ($this->uri->segment(3)) $receiver_id=$this->uri->segment(3); else $receiver_id="";?>

<script>
jQuery(function($){
		//$("input[name='receiver_rd']").mask("dd99999999");
   		//$("input[name='receiver_contact']").mask("999999?9999");
		//$("input[name='receiver_name']").mask("өө?өөөөөөөөөөөөөөөөөөөөө");
		//$("input[name='receiver_surname']").mask("өө?өөөөөөөөөөөөөөөөөөөөө");
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
		$('#receiver_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="receiver_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#receiver_result').append('<p id="responce">'+responce+'</p>');	
									$('#loading').remove();
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
echo "<h3>Online захиалагчийн мэдээлэл</h3>";
	echo form_open('online/online_creating');
	if ($receiver_id!="")
	{
	echo form_hidden("receiver_id",$receiver_id);
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
	echo anchor ("online/online_create","Өөр хүн",array("class"=>"button"));
	echo "</div>";
	}
	else 
	{
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
	echo "<span class='formspan'>Утас:(*)</span>";
	echo  "<input type='text' name='receiver_contact' required='required' required oninvalid='this.setCustomValidity(\"Утасны дугаарын заавал оруулна уу\")'>";
	//echo form_input ("receiver_contact")."<div id=\"receiver_result\"></div><br>";
	echo "<span class='formspan'>Нэр:(*)</span>";
	echo  "<input type='text' name='receiver_name' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн нэр заавал оруулна уу\")'>";
	echo "<span class='formspan'>Овог:(*)</span>";
	echo  "<input type='text' name='receiver_surname' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн овог заавал оруулна уу\")'>";
	echo "<span class='formspan'>РД:(*)</span>";
		echo  "<input type='text' name='receiver_rd' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн регистрийн дугаар оруулна уу\")'>";
	echo "<span class='formspan'>И-мейл:</span>";
	echo  "<input type='text' name='receiver_email' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн и-мэйл хаяг дугаар оруулна уу\")'><br>";

	echo "<span class='formspan'>Хаяг:(*)</span>";
	echo  "<textarea name='receiver_address' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн хаяг дугаар оруулна уу\")'></textarea>";
	echo "</div>";
	}
	
	echo "<div class=\"box\">";
	echo "<h4 class=\"legend\">Бараа</h4>";
	echo "<span class='formspan'>Веблинк:(*)</span>";echo  "<textarea name='online_url' required='required' required oninvalid='this.setCustomValidity(\"Барааны тухай мэдээлэл заавал оруулна\")'></textarea><br>";
	echo "<span class='formspan'>Тоо ширхэг:(*)</span>";
		echo  "<input type='text' name='online_number' required='required' required oninvalid='this.setCustomValidity(\"Барааны тухай мэдээлэл заавал оруулна\")'>";
;
	echo "<span class='formspan'>Размер:</span>";
	echo  "<input type='text' name='online_size'>";
	echo "<span class='formspan'>Өнгө:</span>";
	echo  "<input type='text' name='online_color'>";
	
	echo "</div>";
	echo form_submit("submit","Бараа нэмэх");
	echo form_close();
	echo "<span class='info'>(*)-заавал бөглөх талбарууд </span>";
	echo "<span class='info'>Email болон Утасын үнэн зөв оруулснаар захиалга хийгдэнэ</span>";
	echo "<span class='info'>Холбоо барих утас: 96669794, 99037509 </span>";


?>

</div><!--content-->
<div id="right_side">
<? $this->load->view("left_content");?>
<div id="side_menu">
<? if ($this->session->userdata('login')) 
echo '<ul>
<li>'.anchor('online', 'Илгээмжүүд').'</li>
<li>'.anchor('online/create', 'Илгээмж оруулах').'</li>
</ul>';
?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->