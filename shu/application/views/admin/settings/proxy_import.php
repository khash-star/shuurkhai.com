<div class="panel panel-primary">
  <div class="panel-heading">Public Proxy import</div>
  <div class="panel-body">
<p>Жишээ</p>
<img src="<?=base_url();?>assets/images/proxy_example.jpg" width="750"/>
<? 
echo "<h3>Proxy-г олноор импортлох</h3>";
echo form_open_multipart('admin/proxy_adding_excel');
echo "<span class='formspan'>файлаа заах:(*)</span>";
echo form_upload("xlsx_file");
echo form_submit("submit","импортлох",array("class"=>"btn btn-success"));
echo form_close();

?>
</div>
</div>

<?=anchor("admin/proxy/","Бүх public proxy",array("class"=>"btn btn-primary")); ?>
