<? 
$customer_id = $this->session->userdata('agent_id');
?>

<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("agents/customers_insert","Хэрэглэгч бүртгэх");?>
  </li>
  
  <li class="list-group-item">
   	<? 	
	echo anchor("agents/customers","Бүх хэрэглэгчид");?>
  </li>
</ul>
  </div>
</div>