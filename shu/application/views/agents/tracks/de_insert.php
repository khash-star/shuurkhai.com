<script>
$(document).ready(function(e) {
    $("input[name='barcode']").focus();
});
</script>

<div class="panel panel-success">
  <div class="panel-heading">Track</div>
  <div class="panel-body">
<? 
echo form_open('agents/tracks_checking');
echo '<div class="d-none"><input type="checkbox" name="delaware" value="1" checked> DE</div>';
echo form_input ("track","",array("class"=>"form-control mt-10","placeholder"=>"Тrack Жишээ:1Z3882748274926..."));
echo form_submit("submit","Оруулах",array("class"=>"btn btn-success"));
echo form_close();
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?=anchor("agents/tracks","All track",array("class"=>"btn btn-primary"));?>