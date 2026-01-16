<script>
$(document).ready(function(e) {
    $("input[name='barcode']").focus();
});
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Tracks оруулах</div>
  <div class="panel-body">
<? 
echo form_open('admin/tracks_checking');
echo form_input ("track","",array("class"=>"form-control"));
echo form_submit("submit","add",array("class"=>"btn btn-success"));
echo form_close();
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->
