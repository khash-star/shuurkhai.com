<? if ($this->uri->segment(3)) $error=$this->uri->segment(3); else $error = NULL;?>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<div class="box">
<h4 class="legend">Утасны дугаараа оруулна уу.</h4>
<? 
if ($error==404) echo "<span class='error'>Утасны дугаар хоосон байна</span><br>";
if ($error==405) echo "<span class='error'>Утасны дугаар зөвхөн тоо бичигдэнэ</span><br>";

echo form_open('customers/pre_registering');

echo "<span class='formspan'>Утас:(*)</span>";
echo "<input type='text' name='contacts' autofocus='autofocus' required='required'>";
//echo form_input (array('name'=>'contacts','autofocus'=>'autofocus'));
echo form_submit("submit","бүртгүүлэх");
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