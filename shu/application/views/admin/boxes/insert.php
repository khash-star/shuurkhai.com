<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Box insert</h3>";
echo form_open('agents/boxes_inserting');
echo "<span class='formspan'>Name:(*)</span>";
echo form_input ("box_name")."<br>";
echo form_submit("submit","add");
echo form_close();

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('boxes', 'Boxes')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->