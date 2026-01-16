<div class="panel panel-primary">
  <div class="panel-heading">Буцаалт</div>
  <div class="panel-body">
<? 
	if (!$this->uri->segment(3)) 
	{
		echo '<div class="alert alert-warning" role="alert">';
		echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
		echo 'Буцаах баримтын дугаар. Зөвхөн энэ өдөр гардуулсан барааны баримтын дугаар';
		echo '</div>';
	}
	
	if ($this->uri->segment(3)!="") 
	{
		echo '<div class="alert alert-danger" role="alert">';
		echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
		echo $this->uri->segment(3)." дугаартай баримтын буцаах гэж байна.";
		echo '</div>';
	}
	echo form_open ("admin/reversing");
	echo form_textarea("bill_id",$this->uri->segment(3),array("class"=>"form-control","placeholder"=>"12345","autofocus"=>"autofocus"));
	echo form_submit("submit","Буцаах",array("class"=>"btn btn-success"));
	echo form_close();


?>

</div>
</div>