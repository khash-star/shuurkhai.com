<? 
	if ($this->uri->segment(3)) $box_id=$this->uri->segment(3); else redirect('admin/boxes');
	if (isset($_POST["box_id"])) $box_id=$_POST["box_id"];

?>

<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  	<ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/boxes', 'Boxes')?></li>
	<li class="list-group-item"><?=anchor('admin/boxes_search', 'Boxes хайх')?></li>
    <li class="list-group-item"><?=anchor('admin/boxes_preview/'.$box_id, 'Гадуур дагавар')?></li>
	<li class="list-group-item"><?=anchor('admin/boxes_history', 'Boxes түүх')?></li>
	</ul>
    
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->