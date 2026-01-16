<script src="<?=base_url();?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url();?>assets/ckeditor/config.js"></script>

<div class="panel panel-primary">
  <div class="panel-heading">SETTINGS:PAGE1</div>
  <div class="panel-body">
<? 



	echo form_open('admin/page_editing');
	$file_name = "application/views/page1.php";
	$data ="";
 	$fp = @fopen($file_name, "r");
                  while(!feof($fp)) {
                       $data .= fgets($fp, filesize($file_name));
                   }
				   echo form_textarea ("page_content",$data,array("id"=>"page_content","rows"=>"10","height"=>"300"));
                   fclose($fp);


	echo form_submit("submit","засах",array("class"=>"btn btn-success"));
	echo form_close();
?>


</div> <!--PANEL-BODY-->
</div> <!--PANEL-->

<script>
(function() {
	CKEDITOR.replace( 'page_content', {
		uiColor : '#2D62B2',
		autoParagraph : false,
		baseHref:'<?=base_url()?>'
	} );	
})();
</script>