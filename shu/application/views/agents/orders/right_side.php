<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  	<ul class="list-group">
	<li class="list-group-item"><?=anchor('admin/agents', 'Agents')?></li>
	<li class="list-group-item"><?=anchor('admin/agents_insert', 'Agent нэмэх')?></li>
    <? 
	if (isset($agent_id)) 
	{
	echo '<li class="list-group-item">.'.anchor('admin/agents_delete/'.$agent_id, 'Agent устгах').'</li>';
	echo '<li class="list-group-item">.'.anchor('admin/agents_history/'.$agent_id, 'Agent-н түүх').'</li>';
	}
	?>
	</ul>
    
  </div><!-- PANEL-BODY -->
</div><!-- PANEL -->