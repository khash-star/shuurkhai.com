<div class="panel panel-primary">
  <div class="panel-heading">Мэдэгдэл: Оруулах</div>
  <div class="panel-body">
<? 

	echo form_open('admin/alert_creating');
	echo form_textarea ("context","",array("class"=>"form-control","placeholder"=>"Мэдэгдэл"))."<br>";
	echo form_input ("link","",array("class"=>"form-control","placeholder"=>"https://www.shuurkhai.com/online.php"))."<br>";
	echo "<i>Линкийг хоосон орхиж болно</i>";
	echo form_submit("submit","нэмэх",array("class"=>"btn btn-success"));
	echo form_close();

?>

</div>
</div>