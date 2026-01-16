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
	//$("#agreement").hide();
	
   $("[name='trigger']").click(function(){
	$("#agreement").toggle(100);
	})	
})
</script>

<div class="panel panel-danger">
  <div class="panel-heading">Нууц үг солих</div>
  <div class="panel-body">
<?
echo form_open('customer/profile_password_changing');
echo form_password("old","",array("placeholder"=>"хуучин нууц үг","class"=>"form-control"))."<br>";
echo form_password("new1","",array("placeholder"=>"шинэ нууц үг","class"=>"form-control"))."<br>";
echo form_password("new2","",array("placeholder"=>"шинэ нууц үг (давт)","class"=>"form-control"))."<br>";

echo form_submit("submit","солих",array("class"=>"btn btn-danger"));
echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<? //$this->load->view("shops");?>
