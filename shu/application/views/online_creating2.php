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
})
</script>


<div class="panel panel-default">
  <div class="panel-heading">Захиалгыг хэн өгч байна?</div>
  <div class="panel-body">
<? 
echo form_open("welcome/online_registering");
echo form_hidden("url",$_POST["url"]);
echo form_hidden("number",$_POST["number"]);
echo form_hidden("size",$_POST["size"]);
echo form_hidden("color",$_POST["color"]);
echo form_hidden("description",$_POST["description"]);
	echo "<h3>Утасны дугаараа оруулна уу.</h3>";

	echo form_input("contact","",array("placeholder"=>"Утасны дугаар Жишээ:99123456)","class"=>"form-control"))."<br>";	

	echo form_submit("Засах","Илгээх",array("class"=>"btn btn-primary"));
	//echo " ";
	//echo anchor("customer/online_create","Ахин нэмэх",array("class"=>"btn btn-default"));
	//echo " ";
	//echo anchor("customer/online","Бүх захиалгууд",array("class"=>"btn btn-default"));
echo form_close();
?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<!--a href="<? //base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<? //base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a-->