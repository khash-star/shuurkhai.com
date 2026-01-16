<? if ($this->uri->segment(3)) $tel = $this->uri->segment(3); else $tel="";?>
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
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<div class="box">
<h4 class="legend">Бүртгүүлэх</h4>
<? 
echo form_open('customers/registering');
echo "<span class='formspan'>Утас:(*)</span>";
if ($tel!="") echo form_input (array('name'=>'contacts','value'=>$tel,'readonly'=>'true'))."<br>";
if ($tel=="") echo form_input (array('name'=>'contacts','value'=>$tel,'autofocus'=>'autofocus'))."<br>";
echo "<span class='formspan'>Нэр:(*)</span>";
echo "<input type='text' name='customers_name' required='required' autofocus='autofocus' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн мэдээлэл дутуу\")'><br>";
echo "<span class='formspan'>Овог:(*)</span>";
echo "<input type='text' name='customers_surname' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн мэдээлэл дутуу\")'><br>";
echo "<span class='formspan'>РД:(*)</span>";
echo "<input type='text' name='customers_rd' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн мэдээлэл дутуу\")'><br>";
echo "<span class='formspan'>Э-мэйл:</span>";
echo "<input type='text' name='email' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн мэдээлэл дутуу\")'><br>";
echo "<span class='formspan'>Хаяг:</span>";
echo "<textarea name='address' required='required' required oninvalid='this.setCustomValidity(\"Хэрэглэгчийн мэдээлэл дутуу\")'></textarea><br>";
echo form_submit("submit","Үргэлжлүүлэх");
echo form_close();

?>
</div> <!-- BOX DIV -->
<?php 
echo "<span class='info'>(*)-заавал бөглөх талбарууд </span><br>";
echo "<span class='info'>Холбоо барих утас: 96669794, 99037509 </span>";
?>
</div> <!-- content DIV -->
<div id="right_side">
<? $this->load->view("left_content");?>
<div id="side_menu">

</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->