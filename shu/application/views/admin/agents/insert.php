<div class="panel panel-primary">
  <div class="panel-heading">Агентийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 

	echo form_open('admin/agents_inserting');
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".form_input ("name","", array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нэвтрэх нэр</td><td>".form_input ("username","", array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нууц үг</td><td>".form_password ("password","", array("class"=>"form-control"))."</td></tr>";
	echo "<tr><td>Нууц үг (давт)</td><td>".form_password ("password2","", array("class"=>"form-control"))."</td></tr>";
	echo "</table>";
	echo form_submit("submit","Бүртгэх", array("class"=>"btn  btn-success"));
	echo form_close();


 


?>
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->