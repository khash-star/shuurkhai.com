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
<img src="<?=base_url();?>assets/import_sample.jpg" width="750"/>
<? 
echo "<h3>Үйлчлүүлэгч олноор нь импортлох</h3>";
echo form_open_multipart('customers/importing');
echo "<span class='formspan'>файлаа заах:(*)</span>";
echo form_upload("xlsx_file");
echo form_submit("submit","импортлох");
echo form_close();

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents/customers', 'Үйлчлүүлэгчид')?></li>
<li><?=anchor('agents/customers_insert', 'Үйлчлүүлэгч оруулах')?></li>
<li><?=anchor('agents/customers_import', 'Импортлох')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->