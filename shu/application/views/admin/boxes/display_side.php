<? 
	if ($this->uri->segment(3)) $box_id=$this->uri->segment(3);
	if (isset($_POST["box_id"])) $box_id=$_POST["box_id"];

?>

<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  	<ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/boxes', 'Boxes')?></li>
	<li class="list-group-item"><?=anchor('admin/boxes_search', 'Boxes хайх')?></li>
    <? 
	if (isset($box_id)) 
	{
	echo '<li class="list-group-item">.'.anchor('admin/box_inside/'.$box_id, 'Box inside').'</li>';
	}
	?>
	<li class="list-group-item"><?=anchor('admin/boxes_history', 'Boxes түүх')?></li>
	<li class="list-group-item"><?=anchor('admin/boxes_excel_refresh', 'Excel файл шинэчлэх')?></li>
    <li class="list-group-item"><?=anchor(base_url().'assets/xlsx/boxes_all.xlsx', 'Excel файл татах')?></li>
	</ul>
    
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->