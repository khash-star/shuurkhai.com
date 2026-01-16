<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery.ui.themes/flick/jquery-ui.css"/>



<script type="text/javascript">
$(document).ready(function() {
	
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

	$( "input[name='date']" ).datepicker();
	$('input[name="contacts"]').change(function(){
		//$('#result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check2',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
					if (responce!="")
					{
						var responce_json = JSON.parse(responce);
						$('input[name="name"]').val(responce_json.name);
						alert("Хэрэглэгчийн мэдээлэл олдлоо");
					}
					else 
					{	
						$('input[name="name"]').val("");
						alert("Хэрэглэгч олдсонгүй!");
					}
				}
			});	
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/later_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
					if (responce!="")
					{
						//var responce_json = JSON.parse(responce);
						$('input[name="balance"]').val(responce);
						//alert("Хэрэглэгчийн мэдээлэл олдлоо");
					}
					else 
					{	
						$('input[name="balance"]').val(0);
						//alert("Хэрэглэгч олдсонгүй!");
					}
				}
			});	
		});			

			
})
</script>
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Дараа тооцоо төлөх</div>
  <div class="panel-body">
<? 
	echo '<div class="alert alert-warning" role="alert">';
  	echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
  	echo 'Хүлээн авагчийн утасны дугаар оруулах.';
	echo '</div>';
	echo form_open ("admin/later_paid");
	echo "<span>Утас:</span>";
	echo form_input("contacts","",array("class"=>"form-control","placeholder"=>"99123456","autofocus"=>"autofocus"));
	echo "<span>Нэр:</span>";
	echo form_input("name","",array("class"=>"form-control","readonly"=>"true"));
	echo "<span>Үлдэгдэл:</span>";
	echo form_input("balance","",array("class"=>"form-control","readonly"=>"true"));
	echo "<span>Төлбөр:</span>";
	echo form_input("payment","",array("class"=>"form-control"));
	echo "<span>Огноо:</span>";
	echo form_input("date",date("Y-m-d"),array("class"=>"form-control","placeholder"=>date("Y-m-d")));
	echo "<span>Тайлбар:</span>";
	echo form_input("description","",array("class"=>"form-control","placeholder"=>"Тайлбар"));
	echo form_submit("submit","Төлбөр төлсөн",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>