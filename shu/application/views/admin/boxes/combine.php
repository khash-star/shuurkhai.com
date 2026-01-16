<div class="panel panel-success">
  <div class="panel-heading">Хамааралтай ачааг олох</div>
  <div class="panel-body">
<? 
  	echo 'Нэгтгэх ачааны barcode-г оруулна уу.';
	echo form_open ("agents/boxes_combining");
	echo form_textarea("combine","",array("class"=>"form-control","placeholder"=>"GO15091855MN","autofocus"=>"autofocus"));
	echo form_submit("submit","Нэгтгэх",array("class"=>"btn btn-success"));
	echo form_close();


?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->