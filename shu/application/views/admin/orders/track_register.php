<? if ($this->uri->segment(3)) $track=$this->uri->segment(3); else redirect("orders/track","refresh",0);?>
<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<div class="box">
<h4 class="legend">Утасны дугаараа оруулна уу.</h4>
<? 
echo "Track №<b>".$track."</b> -д хүлээн авагчийн мэдээлэл бөглөгдөж байж Америкаас гарах боломжтой.<br>";
echo form_open('orders/track_registering');
echo form_input (array('value'=>$track,'type'=>'hidden','name'=>'track'));
echo "<span class='formspan'>Утас:(*)</span>";
echo "<input type='text' name='contacts' autofocus='autofocus' required>";
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
<? $this->load->view("calendar");?>
<div id="side_menu">

</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->