<script type="text/javascript" src="<?=base_url();?>assets/js/jquery.chained.min.js"></script>




<div class="panel panel-primary">
  <div class="panel-heading">Үйлчлүүлэгч нэмэх</div>
  <div class="panel-body">
<? 
echo form_open('admin/customers_inserting');
echo "<table class='table table-hover'>";
echo "<tr><td>Нэр:(*)</td><td>".form_input ("customers_name","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Овог:</td><td>".form_input ("customers_surname","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>РД:</td><td>".form_input ("customers_rd","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Утас:(*)</td><td>".form_input ("contacts","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Э-мэйл:</td><td>".form_input ("email","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Хаяг:</td><td>".form_textarea ("address","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Нэмэлт  мэдээлэл:</td><td>".form_textarea ("address_extra","",array("class"=>"form-control"))."</td></tr>";

echo "<tr><td>Хот, аймаг</td><td>";
	?>
		<select name="city" class="form-control" id="city">
		<?
		$sql =  "SELECT *FROM city";
		$query_cities = $this->db->query($sql);
		foreach ($query_cities->result() as $row)
		{
			?>
			<option value="<?=$row->id;?>"><?=$row->name;?></option>
			<?
		}
		?>
		</select>
	<?
	echo "</td></tr>";
	echo "<tr><td>Дүүрэг, сум</td><td>";
	?>
		<select name="district" class="form-control" id="district">
		<?
		$sql =  "SELECT *FROM district";
		$query_cities = $this->db->query($sql);
		foreach ($query_cities->result() as $row)
		{
			?>
			<option value="<?=$row->id;?>" data-chained="<?=$row->city_id;?>"><?=$row->name;?></option>
			<?
		}
		?>
		</select>
	<?
	echo "</td></tr>";

echo "<tr><td>Баг, хороо</td><td>".form_input("khoroo","",array("class"=>"form-control"))."</td></tr>";
echo "<tr><td>Байр, гудамж</td><td>".form_input("build","",array("class"=>"form-control"))."</td></tr>";



echo "<tr><td>Proxy авахгүй</td><td>".form_checkbox("no_proxy")."</td></tr>";	

echo "</table>";
echo form_submit("submit","нэмэх",array("class"=>"btn btn-primary"));
echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->



<script>
$(document).ready(function(e) {
	$("#district").chained("#city");
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
			
	
	
	
   //$("input[name='reg_number']").mask("өө99999999");
   $("input[name='contacts']").mask("999999?9999");
   
   
   
   $('input[name="contacts"]').change(function(){
		$('#customers_result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#customers_result').append('<p id="responce">'+responce+'</p>');
									$('#loading').remove();
									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="customers_rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="customers_surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="customers_name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
})
</script>