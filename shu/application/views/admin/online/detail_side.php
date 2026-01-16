<? 
$online_id=$this->uri->segment(3); ?>

<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li  class="list-group-item"><?=anchor('admin/online', 'Бүх online')?></li>
	<li  class="list-group-item"><?=anchor('admin/online_history', 'Түүх')?></li>
</ul>
</ul>
  </div>
</div>