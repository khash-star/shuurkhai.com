<div class="panel panel-primary">
  <div class="panel-heading">Асуулт үүсгэх</div>
  <div class="panel-body">
	<? 
	echo form_open('admin/faqs_creating');
	echo "<span class='formspan'>Асуулт(*)</span>";
	echo form_input ("question","",array("class"=>"form-control","required"=>"required"))."<br>";
	echo "<span class='formspan'>Хариулт(*)</span>";
	echo form_textarea ("answer","",array("class"=>"form-control","required"=>"required"))."<br>";
	echo form_submit("submit","Үүсгэх",array("class"=>"btn btn-success"));
	echo form_close();

	?>
	
	</div>
</div>