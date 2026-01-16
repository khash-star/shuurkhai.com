<div class="panel panel-primary">
  <div class="panel-heading">Чингэлэгийн гардуулалт</div>
  <div class="panel-body">
<? 
	echo form_open ("admin/deliver_select_container");
	echo form_input("tel","",array("class"=>"form-control","placeholder"=>"99161843","autofocus"=>"autofocus"));
	echo form_submit("submit","Олголт",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>