<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li  class="list-group-item"><?=anchor('admin/orders', 'Илгээмжүүд')?></li>
    <li  class="list-group-item"><?=anchor('admin/tracks', 'Track')?></li>
    <li  class="list-group-item"><?=anchor('admin/deliver', 'Олголт')?></li>
    <li class="list-group-item"><?=anchor(base_url().'assets/handover.xlsx', 'Excel файл татах (Дотоод)')?></li>
    <li class="list-group-item"><?=anchor(base_url().'assets/handover_offshore.xlsx', 'Excel файл татах (Гадаад)')?></li>

</ul>
  </div>
</div>