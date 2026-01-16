<script src="<?=base_url();?>assets/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.themes/flick/jquery-ui.css"/>
<script language="javascript">
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Календарчилал</div>
  <div class="panel-body">
<? 

	echo form_open('settings/event_creating');
	echo "<span class='formspan'>Үйл явдал:(*)</span>";
	echo form_input ("description")."<br>";
	echo "<span class='formspan'>Огноо(*)</span>";
	$data = array(
              'name'        => 'event_date',
              'id'          => 'datepicker',
              'value'       => date("y-m-d")
            );
	echo form_input ($data)."<br>";
	echo "<span class='formspan'>Цаг:</span>";
	echo form_input ("time",date("G:i:s"))."<br>";
	echo form_submit("submit","нэмэх");
	echo form_close();

?>

</div>

<div id="right_side">
<? $this->load->view("calendar");?>
<? $this->load->view("rate");?>
<div id="side_menu">
<ul>
<li><?=anchor('settings/edit', 'Тохиргоог өөрчлөх')?></li>
<li><?=anchor('settings/events', 'Календарчилал')?></li>
<li><?=anchor('settings/logs', 'Log харах')?></li>
</ul>

</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->