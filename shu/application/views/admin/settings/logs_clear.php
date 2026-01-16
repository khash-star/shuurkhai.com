<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<h3>Log</h3>
<? 
if ($this->db->query("TRUNCATE TABLE logs")) echo "Амжилттай цэвэрлэлээ<br>";else echo "Error".$this->db->error()."<br>";

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