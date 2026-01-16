<div class="panel panel-primary">
  <div class="panel-heading">Олголт</div>
  <div class="panel-body">
<? 
	if (!$this->uri->segment(3)) 
	{
		echo '<div class="alert alert-warning" role="alert">';
		echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
		echo 'Та олгох барааны Barcode.';
		echo '</div>';
	}
	
	if ($this->uri->segment(3) =="notfound") 
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
		echo 'Barcode олдсонгүй</b>.';
		echo '</div>';
	}
	echo form_open ("admin/deliver_select");
	echo form_textarea("deliver","",array("class"=>"form-control","placeholder"=>"GO15091855MN","autofocus"=>"autofocus"));
	echo form_submit("submit","Олголт",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>