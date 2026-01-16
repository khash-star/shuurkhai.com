<div class="panel panel-primary">
  <div class="panel-heading">Мэдээ: Оруулах</div>
  <div class="panel-body">
<? 

	echo form_open('admin/news_creating');
	echo form_input ("title","",array("class"=>"form-control","placeholder"=>"Гарчиг"))."<br>";
	echo form_textarea ("context","",array("class"=>"form-control","placeholder"=>"Мэдээ"))."<br>";
	echo form_submit("submit","нэмэх",array("class"=>"btn btn-success"));
	echo form_close();

?>

</div>
</div>