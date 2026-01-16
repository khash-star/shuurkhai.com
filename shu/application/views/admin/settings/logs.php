<script src="<?=base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/images/jquery.ui.themes/flick/jquery.ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/images/jquery.ui.themes/flick/jquery-ui.css"/>

<script>
$(document).ready(function() {
	$("#delete_button").click(function(){
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:200,
		modal: true,
		buttons: 
		{
			
			"Үгүй": function() {
			$( this ).dialog( "close" );
			},
	
			"Тийм": function() {
			$( this ).dialog( "close" );
			window.location="<?=base_url()?>index.php/admin/logs_clear";
			}
		}
	});
	});
});
</script>
<div id="dialog-confirm" title="Log устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Системийн бүх Log-н бичиглэлийг устгах уу?</p>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Logs</div>
  <div class="panel-body">
<? 
echo "<table class='table table-hover small'>";
echo "<tr><th>Хугацаа</th><th>Log</th><th>Төрөл</th></tr>";
$query=$this->db->query("SELECT * FROM logs ORDER BY timestamp DESC");
if ($query->num_rows()==0) echo "<tr><td colspan='3'></td></tr>";
else {
		foreach ($query->result() as $row)
		{
		echo "<tr><td>".$row->timestamp."</td><td>".$row->logs."</td><td>".$row->type."</td></tr>";
		}
	 }
echo "</table>";
echo "<span id='delete_button' class='btn btn-danger btn-xs'>log цэвэрлэх</span>";
?>

</div>
</div>