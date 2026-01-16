<div class="panel panel-primary">
  <div class="panel-heading">Баазаас трак хайх</div>
  <div class="panel-body">
<? 
	echo form_open ("admin/track_search_result");
	echo form_input("search","",array("class"=>"form-control","required"=>"required","autofocus"=>"autofocus"));
	echo form_submit("submit","Хайх",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>