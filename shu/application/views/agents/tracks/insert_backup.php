<script type="application/javascript">
$(document).ready(function(e) {
	$('input[name="barcode"]').keypress(function(e){
		if (e.which==13)
		{
		$('#result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var barcode= $('input[name="barcode"]').val();
		
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/tracks_check',
		type:'POST',
		data:'barcode='+barcode,
		success: function(responce){
									
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

									
									$('input[name="barcode"]').val('');
									$('#result').empty('');
									$('#loading').remove();
									$('#result').append(responce);	
									}
		});	
		
		}	
	});
	})
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Tracks оруулах</h3>";
echo "<div class=\"box\">";
//echo form_open('orders/creating');
echo "<h4 class=\"legend\">Tracks</h4>";
echo form_input ("barcode");
//echo form_button("check","check");
echo "<div id=\"result\"></div><br>";
//echo form_submit("submit","нэмэх");
//echo form_close();
echo "</div>";
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->