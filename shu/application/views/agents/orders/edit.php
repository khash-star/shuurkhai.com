<? if (!$this->uri->segment(3)) redirect('orders'); else $order_id=$this->uri->segment(3) ?>
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
		var str = str.replace(",", "."); 
		var str = str.replace("Kg", ""); 
		var str = str.replace("kg", ""); 
		var str = str.replace("KG", ""); 
		var str = str.replace("Кг", ""); 
		var str = str.replace("кг", ""); 
		var str = str.replace("КГ", ""); 
		var weight = parseFloat(str);
		$(this).val(weight);
		if (weight<=0.5)  $('#Package_advance_value').val(5);
		 if (weight>0.5 && weight<=1) $('#Package_advance_value').val(8);
		if (weight>1) {var dd = $(this).val()*8; $('#Package_advance_value').val(dd.toFixed(2));}
		});
	//$("div.more").hide();
	/*$( "span#more_toggle" ).click(function() {
			$( "div.more" ).toggle( "fast", function() {});
			if ($(this).html()=="more") 
			$(this).html('<span class="glyphicon glyphicon-menu-up"></span>less'); 
			else $(this).html('<span class="glyphicon glyphicon-menu-down"></span>more');
			});
	*/
	})
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Илгээмж засах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$package=$row->package;
	$barcode=$row->barcode;
	$weight=$row->weight;
	$sender_id=$row->sender;
	$receiver_id=$row->receiver;
	$Package_advance=$row->advance;
	$Package_advance_value=$row->advance_value;
	$transport=$row-> transport;
	$status=$row-> status;
	$agent_id=$row-> agents;
	if ($agent_id ==$this->session->userdata('agent_id'))
	{
		if ($status=="new")
		{
		echo form_open('agents/editing');
		echo form_hidden('order_id',$order_id);
		echo form_hidden('barcode',$barcode);
		echo "<table class='table table-hover'>";
		
	echo "<tr>";
	echo "<td>Хүргэлт</td>";
	echo "<td>";
	echo '<div class="input-group">';
	echo '<span class="input-group-addon" id="basic-addon1">Хүргэлттэй</span>';
	if ($transport==1) $transport_check=TRUE; else  $transport_check=FALSE;
	echo '<span class="input-group-addon">'.form_checkbox("transport","1",$transport_check).'</span>';
	echo '  ';
	echo "</td>";
	echo "</tr>";
	
	
	echo "<tr><th colspan='2'><h4>Илгээгч</h4></th></tr>";
	echo "<tr><td>Утас:(*)</td><td>".form_input ("sender_contact",customer($sender_id,"tel"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td colspan='2'><span id='sender_result' class='alert alert-danger small' role='alert'></span></td></tr>";
	echo "<tr><td>Нэр(*)</td><td>".form_input ("sender_name",customer($sender_id,"name"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Овог</td><td>".form_input ("sender_surname",customer($sender_id,"surname"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>И-мейл(*)</td><td>".form_input ("sender_email",customer($sender_id,"email"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("sender_address",customer($sender_id,"address"),array("class"=>"form-control"))."</td></tr>";
	
	echo "<tr><th colspan='2'><h4>Хүлээн авагч</h4></th></tr>";
	echo "<tr><td>Утас:(*)</td><td>".form_input ("receiver_contact",customer($receiver_id,"tel"),array("class"=>"form-control"));
	echo "<span id='receiver_result' class='alert alert-danger' role='alert'></span></td></tr>";
	echo "<tr><td>Нэр(*)</td><td>".form_input ("receiver_name",customer($receiver_id,"name"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Овог</td><td>".form_input ("receiver_surname",customer($receiver_id,"surname"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>И-мейл(*)</td><td>".form_input ("receiver_email",customer($receiver_id,"email"),array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Хаяг(*)</td><td>".form_textarea ("receiver_address",customer($receiver_id,"address"),array("class"=>"form-control"))."</td></tr>";
	
	
	if ($package!="")
   	{$package_array=explode("##",$package);
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
	}
	
	echo "<tr><td>Барааны тайлбар</td><td>";
		echo "<table class='table table-hover'>";
		echo "<tr>";
		echo "<td>".form_input("package1_name",$package1_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
		echo "<td>".form_input("package1_num",$package1_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package1_price",$package1_value,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>".form_input("package2_name",$package2_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
		echo "<td>".form_input("package2_num",$package2_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package2_price",$package2_value,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>".form_input("package3_name",$package3_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүнх, Утас г.м"))."</td>";
		echo "<td>".form_input("package3_num",$package3_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package3_price",$package3_value,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
		echo "</tr>";
	
		echo "<tr>";
		echo "<td>".form_input("package4_name",$package4_name,array("class"=>"form-control","placeholder"=>"Цамц, Цүгх, Утас г.м"))."</td>";
		echo "<td>".form_input("package4_num",$package4_num,array("class"=>"form-control ","placeholder"=>"Тоо ширхэг"))."</td>";
		echo "<td>".form_input("package4_price",$package4_value,array("class"=>"form-control ","placeholder"=>"Үнэ ($)"))."</td>";
		echo "</tr>";
	
		echo "</table>";
	
	echo "<tr><td>Нийт жин/кг/(*)</td><td>".form_input ("weight",$weight,array("class"=>"form-control","id"=>"weight","required"=>"required"))."</td></tr>";
		
	
	echo "<tr>";
	echo "<td>Төлбөр</td>";
	echo "<td>";
	echo 'Үлдэгдэл төлбөртэй: <div class="input-group">';
	echo '<span class="input-group-addon" id="basic-addon1">Төлбөр</span>';
	if ($Package_advance==1) $check=TRUE; else  $check=FALSE;
	echo '<span class="input-group-addon">'.form_checkbox("Package_advance","1",$check).'</span>';
	echo form_input('Package_advance_value',$Package_advance_value,array("class"=>"form-control","id"=>"Package_advance_value"));
	echo "</td>";
	echo "</tr>";


	echo "</table>";
	echo form_submit("submit","Засах",array("class"=>"btn btn-success"));
	echo form_close();
		}
	else echo "Захиалга new төлөвт байхад л засах боломжтой.";
	
	}
	else echo "Таны оруулсан захиалга биш байна.";
}
else echo "Захиалгын дугаар олдсонгүй";

?>

</div>
</div>