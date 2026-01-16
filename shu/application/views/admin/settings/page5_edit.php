<script src="<?=base_url();?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url();?>assets/ckeditor/config.js"></script>

<div class="panel panel-primary">
  <div class="panel-heading">Track оруулах хуудас</div>
  <div class="panel-body">
<? 



	echo form_open('admin/page5_editing');
	$file_name = "application/views/track_insert.php";
	$data ="";
 	$fp = @fopen($file_name, "r");
                  while(!feof($fp)) {
                       $data .= fgets($fp, filesize($file_name));
                   }
				   echo form_textarea ("page_content",$data,array("id"=>"page_content","rows"=>"10","height"=>"300","class"=>"ckeditor"));
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
		baseHref:'<?=base_url()?>',
		height: 700,
		autoParagraph : false
	} );	
})();
</script>