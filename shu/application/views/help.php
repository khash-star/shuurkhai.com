<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<?=base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a>

<div class="clearfix"></div><br />
 <div class="panel panel-primary">
    <div class="panel-heading">Тусламж</div>
      <div class="panel-body">
<? 
	$customer_id = $this->session->userdata('customer_id');
	echo '<table class="table table-hover">';
	echo form_open("welcome/helping");
	echo form_hidden("customer_id",$customer_id);

	if ($customer_id!="")
	{
	echo "<tr><td>Таны нэр</td>";
	echo "<td>".form_input("customer",customer($customer_id,"name"),array("class"=>"form-control", "readonly"=>"readeonly"))."</td></tr>";
	echo "<tr><td>Таны утас</td>";
	echo "<td>".form_input("customer",customer($customer_id,"tel"),array("class"=>"form-control", "readonly"=>"readeonly"))."</td></tr>";
	echo "<tr><td>Таны мэйл</td>";
	echo "<td>".form_input("customer",customer($customer_id,"email"),array("class"=>"form-control", "readonly"=>"readeonly"))."</td></tr>";
	}
	else 
	{
	echo "<tr><td>Таны нэр</td><td>".form_input("name","",array("class"=>"form-control","required"=>"required"))."</td></tr>";
	echo "<tr><td>Таны утас</td><td>".form_input("tel","",array("class"=>"form-control","required"=>"required"))."</td></tr>";
	echo "<tr><td>Таны мэйл</td><td>".form_input("email","",array("class"=>"form-control","required"=>"required"))."</td></tr>";
	}

	echo "<tr><td>Тусламж</td><td>".form_textarea("context","",array("class"=>"form-control","placeholder"=>"Танд яаж туслах вэ?"))."</td></tr>";
	echo '</table>';
	echo form_submit("submit","Илгээх",array("class"=>"btn btn-success"));
	echo form_close();
	

?>
</div>
</div>

