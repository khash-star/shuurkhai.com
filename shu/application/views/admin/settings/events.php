<div class="panel panel-primary">
  <div class="panel-heading">Календарчилал</div>
  <div class="panel-body">
<? 
echo "Нийт:".$this->db->count_all('events')."<br>";
$query = $this->db->query("SELECT * FROM events;");
if ($query->num_rows() > 0)
{
	echo "<table class='table table-hover'>";
	echo "<tr><th>Огноо</th><th>Үйл явдал</th><th>Цаг</th><th></th></tr>";
	foreach ($query->result() as $row)
	{  echo "<tr>";
	   echo "<td>".$row->event_date."</td>"; 
	   echo "<td>".$row->description."</td>"; 
	   echo "<td>".$row->time."</td>"; 
	   echo "<td>".anchor('settings/event_edit/'.$row->id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	} 
	echo "</table>";
}
else echo "Бичиглэл байхгүй";
echo anchor("settings/event_create","Шинээр үүсгэх")."<br>";
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