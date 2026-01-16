<? if (!$this->uri->segment(3)) redirect('settings/events'); else $event_id=$this->uri->segment(3) ?>
<script src="<?=base_url();?>assets/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/jquery.ui.datepicker.css"/>
<script language="javascript">
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Календарчилал</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM events WHERE id=".$event_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$description=$row->description;
	$event_date=$row->event_date; 
	$time=$row->time;

	echo form_open('settings/event_editing');
	echo form_hidden('event_id',$event_id);
	echo "<span class='formspan'>Үйл явдал:(*)</span>";
	echo form_input ("description",$description)."<br>";
	echo "<span class='formspan'>Огноо(*)</span>";
	$data = array(
              'name'        => 'event_date',
              'id'          => 'datepicker',
              'value'       => $event_date
            );
	echo form_input ($data)."<br>";
	echo "<span class='formspan'>Цаг:</span>";
	echo form_input ("time",$time)."<br>";
	echo form_submit("submit","засах");
	echo form_close();
	echo anchor("settings/event_deleting/".$event_id,"устгах");

}
else echo "Үйл явдал байхгүй";

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
<? $this->load->view("calendar");?>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div> <!--wrapper-->