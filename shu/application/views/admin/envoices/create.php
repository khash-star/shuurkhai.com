<div class="panel panel-primary">
  <div class="panel-heading">Нэхэмжлэх үүсгэх</div>
  <div class="panel-body">
<? 
	echo '<div class="alert alert-warning" role="alert">';
  	echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
  	echo 'Нэхэмжлэх үүсгэх барааны Barcode. Хадгалагдахгүйг анхаарна уу.';
	echo '</div>';
	echo form_open ("admin/admin_envoice");
	echo form_textarea("barcodes","",array("class"=>"form-control","placeholder"=>"GO15091855MN","autofocus"=>"autofocus"));
	echo form_submit("submit","Үүсгэх",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>