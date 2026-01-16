<? if (!$this->uri->segment(3)) redirect('agents/container'); else $container_id=$this->uri->segment(3) ?>
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
		//var weight = parseFloat(str);
		$(this).val(str);
		});
	})
</script>


<div class="panel panel-success">
  <div class="panel-heading">Чингэлэгт ачаа оруулах</div>
  <div class="panel-body">
<? 
//require_once('assets/PHP_XLSXWriter/xlsxwriter.class.php');
$query = $this->db->query("SELECT * FROM container WHERE container_id=".$container_id);
if ($query->num_rows()==1)
{
	$row = $query->row();
	$name= 	$row ->name;
	$created= 	$row ->created;
	$departed= 	$row ->departed;
	$expected= 	$row ->expected;
	$description= 	$row ->description;
	$status= 	$row ->status;
	echo "<b>".$name."</b><br>";
	echo "Үүсгэсэн огноо:".$created."<br>";
	echo "Төлөв:".$status."<br>";
	echo "Америкаас гарсан огноо:".$departed."<br>";
	echo "Монголд очих огноо:".$expected."<br>";
	echo "<p>".$description."</p>";

if ($status=="new")
	{

	echo form_open('agents/container_item_inserting');
	echo form_hidden("container_id",$container_id);
	echo "<table class='table table-hover'>";

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

	echo "<tr><td>Тайлбар: (*)</td><td>". form_textarea ("description","",array("class"=>"form-control"))."</td></tr>";

	echo "<tr><td>Нийт жин/кг/(*)</td><td>".form_input ("weight","",array("class"=>"form-control","id"=>"weight","required"=>"required"))."</td></tr>";


	echo "<tr><td>Авсан төлбөр/$/</td><td>".form_input ("payment","",array("class"=>"form-control"))."</td></tr>";

	echo "<tr><td>Монголд авах төлбөр/$/</td><td>".form_input ("pay_in_mongolia","",array("class"=>"form-control"))."</td></tr>";

	echo "</table>";

	echo form_submit("submit","add",array("class"=>"btn btn-success"));
	echo form_close();
	}
	else echo '<div class="alert alert-danger" role="alert">Чинэглэгийн төлөв засаж болохгүй төлөвт байна</div>';
}
else echo '<div class="alert alert-danger" role="alert">Ачааны дугаар алдаатай байна</div>';

?>


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->