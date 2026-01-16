<script type="application/javascript">
$(document).ready(function() {
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
	
	$('input[name="contacts"]').change(function(){
		$('#result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#result').append(responce);
									$('#result').show(500);
									$('#loading').remove();

									if (responce=="Found user") 
									{		
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="name"]').val(responce2);
																	}
												});	
									}
									}
		});	
	});
	
})
</script>
 <div class="panel panel-primary">
    <div class="panel-heading">Тусламж</div>
      <div class="panel-body">

<?
	echo form_open("admin/help_creating");
	echo "<table class='table table-hover'>";    
    echo "<tr><td>Утас:(*)</td><td>".form_input ("contacts","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td colspan='2'><span id='result' class='alert alert-danger alert-small' role='alert'></span></td></tr>";
    echo "<tr><td>Нэр(*)</td><td>".form_input ("name","",array("class"=>"form-control"))."</td></tr>";
    echo "<tr><td>Овог</td><td>".form_input ("surname","",array("class"=>"form-control"))."</td></tr>";


    echo "</table>";
	
	echo '<table class="table table-hover">';
	echo "<tr><td>Тусламж бичих</td><td>".form_textarea("context","",array("class"=>"form-control","placeholder"=>"Тусламж","height"=>"500"))."</td></tr>";
	echo '</table>';
	echo form_submit("submit","Илгээх",array("class"=>"btn btn-success"));
	echo form_close();
?>
</div>
</div>

