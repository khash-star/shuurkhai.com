<script type="application/javascript">
$(function() {
			$(".alert").hide();
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
			
	
	
	
	$('input[name="sender_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="sender_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#sender_result').append(responce);
									$('#sender_result').show(500);
									$('#loading').remove();
									if (responce=="Found user") 
									{
										
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="sender_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="sender_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="sender_email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/agents/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="sender_address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
	
	$('input[name="receiver_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="receiver_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#receiver_result').html('');
									$('#receiver_result').append(responce);
									$('#receiver_result').show(500);	
									$('#loading').remove();
									if (responce=="Found user") 
									{												
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
	$("#weight").on('change',function(){
		var str = $(this).val();
		var payment_rate = <?=settings_new("paymentrate_selfdrop");?>;
		var str = str.replace(",", "."); 
		var str = str.replace("Kg", ""); 
		var str = str.replace("kg", ""); 
		var str = str.replace("KG", ""); 
		var str = str.replace("Кг", ""); 
		var str = str.replace("кг", ""); 
		var str = str.replace("КГ", ""); 
		var weight = parseFloat(str);
		$(this).val(weight);
		if (weight<=0.5)  $('#Package_advance_value').val(10);
		 if (weight>0.5 && weight<=1) $('#Package_advance_value').val(payment_rate);
		if (weight>1) {var total = $(this).val()*payment_rate; $('#Package_advance_value').val(total.toFixed(2));}
		});
	$("div.more").hide();
	$( "span#more_toggle" ).click(function() {
			$( "div.more" ).toggle( "fast", function() {});
			if ($(this).html()=="more") 
			$(this).html('<span class="glyphicon glyphicon-menu-up"></span>less'); 
			else $(this).html('<span class="glyphicon glyphicon-menu-down"></span>more');
			});
	})
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж оруулах</div>
  <div class="panel-body">
<? 
echo form_open('agents/creating');
echo "<table class='table table-hover'>";


echo "<tr>";
echo "<td>Хүргэлт</td>";
echo "<td>";
echo '<div class="input-group">';
echo '<span class="input-group-addon" id="basic-addon1">Хүргэлттэй</span>';
echo '<span class="input-group-addon">'.form_checkbox("transport","1",FALSE).'</span>';
echo ' ';
echo "</td>";
echo "</tr>";


echo "<tr><th colspan='2'><h4>Илгээгч</h4></th></tr>";
echo "<tr><td>Утас:(*)</td><td>".form_input ("sender_contact","",array("class"=>"form-control","required"=>"required"))."</td></tr>";
echo "<tr><td colspan='2'><span id='sender_result' class='alert alert-danger small' role='alert'></span></td></tr>";
echo "<tr><td>Нэр(*)</td><td>".form_input ("sender_name","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Овог</td><td>".form_input ("sender_surname","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>И-мейл(*)</td><td>".form_input ("sender_email","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("sender_address","",array("class"=>"form-control"))."</td></tr>";

echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
echo "<tr><td>Утас:(*)</td><td>".form_input ("receiver_contact","",array("class"=>"form-control","required"=>"required"));
echo "<span id='receiver_result' class='alert alert-danger' role='alert'></span></td></tr>";
echo "<tr><td>Нэр(*)</td><td>".form_input ("receiver_name","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Овог</td><td>".form_input ("receiver_surname","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>И-мейл(*)</td><td>".form_input ("receiver_email","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("receiver_address","",array("class"=>"form-control"))."</td></tr>";




echo "<tr><td>Барааны тайлбар</td><td>";
	echo "<table class='table table-hover'>";
	echo "<tr>";
	echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м","required"=>"required"))."</td>";
	echo "<td>".form_input("package1_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package1_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>".form_input("package2_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
	echo "<td>".form_input("package2_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package2_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>".form_input("package3_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
	echo "<td>".form_input("package3_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package3_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
	echo "</tr>";

	echo "<tr>";
	echo "<td>".form_input("package4_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүгх, Утас г.м"))."</td>";
	echo "<td>".form_input("package4_num","",array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
	echo "<td>".form_input("package4_price","",array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
	echo "</tr>";

	echo "</table>";


echo "<tr><td>Нийт жин/кг/(*)</td><td>".form_input ("weight","",array("class"=>"form-control","id"=>"weight","required"=>"required"))."</td></tr>";


echo "<tr>";
echo "<td>Төлбөр</td>";
echo "<td>";
echo 'Үлдэгдэл төлбөртэй: <div class="input-group">';
echo '<span class="input-group-addon" id="basic-addon1">Төлбөр</span>';
echo '<span class="input-group-addon">'.form_checkbox("Package_advance","1",TRUE).'</span>';
echo form_input('Package_advance_value', '',array("class"=>"form-control","id"=>"Package_advance_value"));
echo "</td>";
echo "</tr>";

/*echo "<div class='more'>";
echo "<div class='box'>";
echo "<h4 class='legend'>Илгээмж явах хэлбэр</h4>";
echo "<span class='formspan'>Агаараар</span>";
echo form_radio('way', 'air', TRUE)."<br>";
echo "<span class='formspan'>Газраар</span>";
echo form_radio('way', 'surface', FALSE)."<br>";
echo "<span class='formspan'>Хосолсон</span>";
echo form_radio('way', 'sal', FALSE)."<br>";
echo "<h4>Хүргэлтийн хэлбэр</h4>";
echo "<span class='formspan'>Express</span>";
echo form_radio('deliver_time', 'express', TRUE)."";
echo "<span class='formspan'>Advice of delivery</span>";
echo form_radio('deliver_time', 'advice', FALSE)."<br>";
echo "</div>";



echo "<div class='box'>";
echo "<h4 class='legend'>Илгээмж доторхи зүйл</h4>";
echo form_radio('Package_inside', 'gift',  TRUE);
echo "Бэлэг<br>";
echo form_radio('Package_inside', 'sample', FALSE);
echo "Арилжааны шинж чанаргүй загвар<br>";
echo form_radio('Package_inside', 'document', FALSE);
echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
echo "</div>";


echo "<div class='box'>";
echo "<h4 class='legend'>Даатгал</h4>";
echo "<span class='formspan'>Даатгалтай</span>";
echo form_checkbox('insurance', '1')."<br>";
echo "<span class='formspan'>Даатгалын төлбөр</span>";
echo form_input('insurance_value', '');
echo "</div>";


echo "<div class='box'>";
echo "<h4 class='legend'>Хүргэгдээгүй тохиолдолд</h4>";
echo form_radio('Package_return_type', 'return_1',  TRUE);
echo "Явуулагч талруу яаралтай буцаах<br>";
echo form_radio('Package_return_type', 'return_2',  FALSE);
echo "Явуулагч талруу __ өдрийн дараа буцаах";
echo " Өдөр";
echo form_input('Package_return_day', '')."<br>";
echo form_radio('Package_return_type', 'return_3',  TRUE);
echo "Өөр хаягруу явуулах"."<br>";
echo "Өөр хаяг";
echo form_textarea ("Package_return_address","")."<br>";
echo form_radio('Package_return_type', 'return_4',  FALSE);
echo "Тэнд нь устгах<br>";
echo "<h4>Буцах хаягруу явуулах</h4>";
echo "<span class='formspan'>Агаараар</span>";
echo form_radio('Package_return_way', 'air',  TRUE);
echo "<span class='formspan'>Газраар</span>";
echo form_radio('Package_return_way', 'surface',  FALSE);
echo "</div>";

echo "</div>";  //MORE DIV CLOSE


echo "<span id='more_toggle'>more</span>";*/
echo "</table>";
echo form_submit("submit","нэмэх",array("class"=>"btn btn-success"));
echo form_close();

?>

</div>
</div>