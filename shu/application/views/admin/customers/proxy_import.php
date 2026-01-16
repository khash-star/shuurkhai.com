<? if (!$this->uri->segment(3)) redirect('admin/customers'); else $customer_id=$this->uri->segment(3) ?>
<div class="panel panel-primary">
  <div class="panel-heading">Хэрэглэгчийн удирдлагын хэсэг</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM customer WHERE customer_id=".$customer_id);

if ($query->num_rows() == 1)
{
	$row = $query->row();
	$name=$row->name;
	$surname=$row->surname; 
	$rd=$row->rd; 
	$contacts=$row->tel;
	$address=$row->address;
	$username=$row->username;
	$password=$row->password;
	$email=$row->email;
	echo "<table class='table table-hover'>";
	echo "<tr><td>Нэр</td><td>".$name."</td></tr>";	
	echo "<tr><td>Овог</td><td>".$surname."</td></tr>";
	echo "<tr><td>РД</td><td>".$rd."</td></tr>";
	echo "<tr><td>Утас</td><td>".$contacts."</td></tr>";	
	echo "<tr><td>Э-мэйл</td><td>".$email."</td></tr>";
	echo "<tr><td>Хаяг</td><td>".$address."</td></tr>";	
	echo "</table>";
	echo anchor('admin/customers_edit/'.$row->customer_id,'Мэдээлэллийг засах',array("class"=>"btn btn-primary"));
}
?>

</div>
</div>




<div class="panel panel-primary">
  <div class="panel-heading">Proxy import</div>
  <div class="panel-body">
<p>Жишээ</p>
<img src="<?=base_url();?>assets/images/proxy_example.jpg" width="750"/>
<? 
echo "<h3>Proxy-г олноор импортлох</h3>";
echo form_open_multipart('admin/customers_proxy_adding_excel');
echo "<span class='formspan'>файлаа заах:(*)</span>";
echo form_hidden("customer_id",$customer_id);
echo form_upload("xlsx_file");
echo form_submit("submit","импортлох",array("class"=>"btn btn-success"));
echo form_close();

?>
</div>
</div>

<?=anchor("admin/customers_proxy/".$customer_id,"Бүх proxy",array("class"=>"btn btn-primary")); ?>
