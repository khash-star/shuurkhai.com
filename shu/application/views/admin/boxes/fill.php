<? if (!$this->uri->segment(3)) redirect('agents/boxes_display'); else $box_id=$this->uri->segment(3) ?>


<script type="application/javascript">
$(document).ready(function(e) {
	$('button[name="add"]').click(function(){
		$('#result').append('<img src="<?=base_url()?>assets/ajax-loader.gif" id="loading">');
		var barcode= $('input[name="barcode"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/agents/boxes_filling',
		type:'POST',
		data:'box_id='+<?=$box_id?>+'&barcode='+barcode,
		success: function(responce){
									$('#result').empty('');
									$('#loading').remove();
									$('#result').append(responce);	
									$('input[name="barcode"]').val('');
									}
		});	
		
			return false;	
	});
	})
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Box filling</h3>";
echo "<div class=\"box\">";
//echo form_open('orders/creating');
echo "<h4 class=\"legend\">Track or Barcode</h4>";
echo form_input ("barcode");
echo form_button("add","add");
echo "<div id=\"result\"></div><br>";
//echo form_submit("submit","нэмэх");
//echo form_close();
echo "</div>";
?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('boxes', 'Boxes')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->