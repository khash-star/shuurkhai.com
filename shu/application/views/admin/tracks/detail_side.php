<? 
$customer_id = $this->session->userdata('agent_id');
if ($this->uri->segment(3))  $order_id=$this->uri->segment(3) ;
if (isset($_POST["order_id"])) $order_id=$_POST["order_id"];
?>

<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery-ui.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/jquery-ui.theme.min.css"/>


<script>
$(document).ready(function() {
	$("#delete_button").click(function(){
		//event.preventDefault();
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
			if(<?=cfg_deletepass();?>==$('#deletepass').val())
				{
					$( this ).dialog( "close" );
					window.location="<?=base_url()?>index.php/admin/tracks_deleting/<?=$order_id?>";
				}
			else alert("Нууц үг буруу байна.");
			}
		}
	});
	});
});
</script>

<div id="dialog-confirm" title="Үйлчлүүлэгчийн мэдээлэл устгах" style="display:none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Трак устгах хэсэг?</p>
	<?php
	echo "<input type='password' name='delete_pass' class='form-control' autocomplete='off'  id='deletepass'>";
	?>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Админ цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
    <li  class="list-group-item"><?=anchor('admin/tracks', 'Tracks')?></li>
    
    
    <? 
	$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
	$query = $this->db->query($sql);
	
	if($query->num_rows()==1)
	{
		$row = $query ->row();

		if ($row ->proxy_id!=0)
		echo '<li class="list-group-item">'.anchor('admin/tracks_proxy_delete/'.$order_id,'Proxy цэвэрлэх').'</li>';
		
		if ($row ->status=="delivered" || $row ->status=="custom")
		{
			echo '<li class="list-group-item">'.anchor('admin/tracks_modify/'.$order_id,'Track солих').'</li>';

		}
		if ($row ->status!="order")
		echo '<li class="list-group-item">'.anchor('admin/tracks_preview/'.$order_id,'Хэвлэх',array('target'=>"new")).'</li>';
	    echo '<li class="list-group-item">';
		
		//form_button("Устгах","Устгах",array("class"=>"btn btn-danger","id"=>"delete_button"));
		echo '<span id="delete_button">Устгах</span>';
		echo '</li>';
		//echo '<li class="list-group-item">'.anchor('admin/edit/'.$order_id,'засах').'</li>';
	}
?>
</ul>
</ul>
  </div>
</div>