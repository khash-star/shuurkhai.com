<div class="panel panel-success">
  <div class="panel-heading">Хамааралтай ачааг олох</div>
  <div class="panel-body">
<? 
echo form_open('agents/boxes_relative_display');

echo form_input ("barcode","",array("class"=>"form-control","placeholder"=>"Track, barcode"))."</td></tr>";

echo form_submit("submit","Хайх",array("class"=>"btn btn-success"));

echo form_close();

?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->