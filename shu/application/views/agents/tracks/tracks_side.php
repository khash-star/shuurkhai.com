<? 
$customer_id = $this->session->userdata('agent_id');
?>

<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item"><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
	<li class="list-group-item"><?=anchor('agents/tracks_de_insert', 'Delaware Track оруулах')?></li>
	<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
</ul>
</ul>
  </div>
</div>