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
			
	
	
	
	$('input[name="sender_contact"]').change(function(){
		$('#sender_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var tel= $('input[name="sender_contact"]').val();
	$.ajax ({
		url: '<?=base_url()?>/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#sender_result').append('<p id="responce">'+responce+'</p>');
									$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="sender_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="sender_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="sender_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="sender_email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>/admin/customers_check',
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
		$('#sender_result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
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
	$( "span#more_toggle" ).click(function() {
			$( "div.more" ).toggle( "slow", function() {});
			if ($(this).text()=="more") 
			$(this).text('less'); else $(this).text('more');
			});
	})
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Илгээмж оруулах</h3>";
echo form_open('orders/creating');
echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Илгээгч</h4>";
echo "<span class='formspan'>Утас:</span>";
echo form_input ("sender_contact")."<span id=\"sender_result\"></span><br>";
echo "<span class='formspan'>Нэр:</span>";
echo form_input ("sender_name")."";
echo "<span class='formspan'>Овог:</span>";
echo form_input ("sender_surname")."";
echo "<span class='formspan'>РД:</span>";
echo form_input ("sender_rd")."<br>";
echo "<span class='formspan'>И-мейл:</span>";
echo form_input ("sender_email")."<br>";
echo "<span class='formspan'>Хаяг:</span>";
echo form_textarea("sender_address")."<br>";
echo "</div>";

echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Хүлээн авагч</h4>";
echo "<span class='formspan'>Утас:</span>";
echo form_input ("receiver_contact")."<span id=\"receiver_result\"></span><br>";
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


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Бараа</h4>";



	echo "<tr><td>Барааны тайлбар</td><td>";
	echo "<table class='table table-hover'>";
	echo "<tr>";
	
	echo "<td>".form_input("package1_name","",array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
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
	echo "</td></tr>";

	
	echo "</table>";
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Төлбөр</h4>";
echo "<span class='formspan'>Төлбөргүй</span>";
echo form_radio('Package_advance', '0',  TRUE);
echo "<span class='formspan'>Үлдэгдэлтэй</span>";
echo form_radio('Package_advance', '1',  FALSE)."<br>";
echo "<span class='formspan'>Үлдэгдэл</span>";
echo form_input('Package_advance_value', '');
echo "</div>";

echo "<div class=\"more\">";
echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Илгээмж явах хэлбэр</h4>";
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



echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Илгээмж доторхи зүйл</h4>";
echo form_radio('Package_inside', 'gift',  TRUE);
echo "Бэлэг<br>";
echo form_radio('Package_inside', 'sample', FALSE);
echo "Арилжааны шинж чанаргүй загвар<br>";
echo form_radio('Package_inside', 'document', FALSE);
echo "Арилжааны шинж чанаргүй бичиг баримт<br>";
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Даатгал</h4>";
echo "<span class='formspan'>Даатгалтай</span>";
echo form_checkbox('insurance', '1')."<br>";
echo "<span class='formspan'>Даатгалын төлбөр</span>";
echo form_input('insurance_value', '');
echo "</div>";


echo "<div class=\"box\">";
echo "<h4 class=\"legend\">Хүргэгдээгүй тохиолдолд</h4>";
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


echo "<span id=\"more_toggle\">more</span>";
echo form_submit("submit","нэмэх");
echo form_close();

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('orders', 'Илгээмжүүд')?></li>
<li><?=anchor('orders/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->