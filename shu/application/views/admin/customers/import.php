<script>
jQuery(function($){
   $("input[name='reg_number']").mask("өө99999999");
   $("input[name='contacts']").inputmask("99999999");
})
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<p>Жишээ</p>
<img src="<?=base_url();?>assets/images/import_sample.jpg" width="750"/>
<? 
echo "<h3>Үйлчлүүлэгч олноор нь импортлох</h3>";
echo form_open_multipart('admin/customers_importing');
echo "<span class='formspan'>файлаа заах:(*)</span>";
echo form_upload("xlsx_file");
echo form_submit("submit","импортлох",array("class"=>"btn btn-success"));
echo form_close();

?>

</div>
</div>
