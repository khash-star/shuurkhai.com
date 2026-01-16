<div class="panel panel-success">
  <div class="panel-heading">Хүргэлтээр гаргах</div>
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
	echo form_open ("admin/handover_select");
	echo form_textarea("handover","",array("class"=>"form-control","placeholder"=>"GO15091855MN","autofocus"=>"autofocus"));
	echo form_submit("submit","Хүргэлтээр гаргах",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>