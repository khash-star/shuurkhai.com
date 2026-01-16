<div class="panel panel-primary">
  <div class="panel-heading">Олголт</div>
  <div class="panel-body">
<? 
	echo '<div class="alert alert-warning" role="alert">';
  	echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
  	echo 'Хүлээн авагчийн утасны дугаар оруулах.';
	echo '</div>';
	echo form_open ("admin/deliver_select");
	echo form_input("tel","",array("class"=>"form-control","placeholder"=>"99123456","autofocus"=>"autofocus"));
	echo form_submit("submit","Олголт",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>