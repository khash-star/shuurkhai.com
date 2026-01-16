<? 
//$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
?>

<div class="panel panel-primary">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  	<ul class="list-group">
		<li  class="list-group-item"><?=anchor('admin/delivered', 'Гардуулсан илгээмж')?></li>
		<li class="list-group-item"><?=anchor('admin/deliver', 'Олголт')?></li>
	    <li class="list-group-item"><?=anchor('admin/deliver_tel', 'Утсаар хайх')?></li>
	</ul>
  </div>
</div>