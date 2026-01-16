<? if ($_POST["event_id"]=="") redirect('settings/events'); else $event_id=$_POST["event_id"]; ?>


<div class="panel panel-primary">
  <div class="panel-heading">Календарчилал</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM events WHERE id=".$event_id);

if ($query->num_rows() == 1)
{
	$event_date=$_POST["event_date"];
	$description=$_POST["description"];
	$time=$_POST["time"]; 
	
	$data = array(
               'event_date' => $event_date,
			   'description' => $description,
			   'time' => $time
            );
	$this->db->where('id', $event_id);
	if ($this->db->update('events', $data)) echo "Амжилттай заслаа.<br>";
	else echo "ERROR".$this->db->error();

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