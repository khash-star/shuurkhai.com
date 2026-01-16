<? if ($this->uri->segment(3)) $track=$this->uri->segment(3); else redirect("orders/track","refresh",0);?>
<? if ($this->uri->segment(4)) $tel = $this->uri->segment(4); else redirect('orders/track_register/'.$track);?>

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
echo "Track №<b>".$track."</b> -д хүлээн авагчийг шинээр бүртгэх.<br>";

echo form_open('orders/track_creating/'.$track."/".$tel);
echo "<span class='formspan'>Утас:(*)</span>";
if ($tel!="") echo form_input (array('name'=>'contacts','value'=>$tel,'readonly'=>'true'))."<br>";
if ($tel=="") echo form_input (array('name'=>'contacts','value'=>$tel,'autofocus'=>'autofocus'))."<br>";
echo "<span class='formspan'>Нэр:(*)</span>";
echo form_input (array('name'=>'customers_name','autofocus'=>'autofocus'))."<br>";
echo "<span class='formspan'>Овог:(*)</span>";
echo form_input ("customers_surname")."<br>";
echo "<span class='formspan'>РД:(*)</span>";
echo form_input ("customers_rd")."<br>";
echo "<span class='formspan'>Э-мэйл:</span>";
echo form_input ("email")."<br>";
echo "<span class='formspan'>Хаяг:</span>";
echo form_textarea("address")."<br>";
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
<? $this->load->view("calendar");?>
<div id="side_menu">

</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->