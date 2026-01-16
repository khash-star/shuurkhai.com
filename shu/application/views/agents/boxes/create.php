<div class="panel panel-success">
  <div class="panel-heading">Box үүсгэх
  <span title="Хайрцаглагдаагүй бэлэн ачаа">(<?=agent_boxed_order();?> new order</span>
  <span title="Хайрцаглагдаагүй бэлэн нэгтгэсэн ачаа">,<?=agent_boxed_combine();?> new combine)</span>
	</div>
 <div class="panel-body">
<? 
echo form_open('agents/boxes_creating');
echo "<table class='table table-hover'>";
echo "<tr><td> Name:(*)</td><td>". form_input ("box_name","",array("class"=>"form-control","placeholder"=>"Жишээ: HDB1500"))."</td></tr>";
echo "</table>";

echo form_submit("submit","add",array("class"=>"btn btn-success"));
echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->