<? if (!$this->uri->segment(3)) redirect('settings/events'); else $event_id=$this->uri->segment(3); ?>


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
	
	echo "Үйл явдал: ".$description."<br>";	
	echo "Огноо: ".$event_date."<br>";
	echo "Цаг:".$time."<br>";
	
	if ($this->db->query("DELETE FROM events WHERE id=".$event_id)) echo "Амжилттай устгалаа";
		else "Error:".$this->db->error;

		
}
else echo "Үйл явдал олдоогүй";

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