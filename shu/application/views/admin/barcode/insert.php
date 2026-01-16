<script type="application/javascript">
$(document).ready(function(e) {
	 $("input[name='barcode']").focus();
	$('input[name="barcode"]').keypress(function(e) {
		if(e.which == 13) {
			$('#result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
			var barcode= $('input[name="barcode"]').val();
			$.ajax ({
				url: '<?=base_url()?>index.php/barcode/inserting',
				type:'POST',
				data:'barcode='+barcode,
				success: function(responce){
								    $('input[name="barcode"]').val('');
									$('#responce').remove();
									$('#result').append('<p id="responce">'+responce+'</p>');	
									$('#loading').remove();
											}
					});	
		}
	})
})
</script>




<div class="panel panel-primary">
  <div class="panel-heading">Barcode:insert</div>
  <div class="panel-body">
<? 
echo form_open('admin/barcode_inserting');
echo "<textarea name='barcode' style='height:400px' autofocus='autofocus' required='required' class='form-control'></textarea>";
//echo form_textarea ("barcode")."<div id=\"result\"></div><br>";
echo form_submit("submit","Оруулах",array("class"=>"btn btn-success"));
//echo form_close();
?>

</div>
</div>