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
<div class="panel panel-success">
  <div class="panel-heading">Та Тракаа бүртгүүлснээр 1&cent; таны хуримтлалын санд нэмэгдэнэ.</div>
  <div class="panel-body">
<? 
echo form_open("customer/orders_creating");
	echo "<table class='table table-hover'>";
	
	echo "<tr>";
	echo "<td><span style='color:#F00'>Хүргэлт</span></td>";
	echo "<td>";
	echo form_checkbox("transport","1",FALSE)."<br><i>Улаанбаатар хот дотор хүргэлттэй</i>";
	echo "</td>";
	echo "</tr>";


	echo "<tr><td>Track</td><td>".form_input("track","",array("class"=>"form-control","placeholder"=>"Жишээ нь: 1Z9999999999999999"))."</td></tr>";
	
	echo "</table>";
	 
	echo form_submit("Үүсгэх","Үргэлжлэх",array("class"=>"btn btn-primary"));
	echo form_close();
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->

<?=anchor("customer/orders","Миний илгээмж",array("class"=>"btn btn-success"));?>




<? //$this->load->view("shops");?>

<script>
$(document).ready(function() {
	$("#receiver_trigger_content").hide();
	$("#sender_trigger_content").hide();
	
   $("[name='sender_trigger']").click(function(){
	$("#sender_trigger_content").toggle(100);
	})
	
	$("[name='receiver_trigger']").click(function(){
	$("#receiver_trigger_content").toggle(100);
	})
	
});
  
</script>