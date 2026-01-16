<div class="panel panel-default">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
  <li class="list-group-item">
    <?=anchor("admin/customers","Бүх үйлчлүүлэгч");?>
  </li>
  
	<li class="list-group-item">
    <?=anchor("admin/customers_insert","Үйлчлүүлэгч бүртгэх");?>
  </li>
  
    <li class="list-group-item">
    <?=anchor("admin/customers_import","Үйлчлүүлэгч файлаас импортлох");?>
  </li>
  
</ul>
  </div>
</div>



	<div class="panel panel-default">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
	<? $this->load->view("page2");?>

  </div><!-- panel-body -->
  </div><!-- panel --> 