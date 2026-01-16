<? 
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Шүүлтүүр</div>
  <div class="panel-body">
  
    <? echo form_open("admin/customers");?>
    <? echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"хайх..."));?>
    <? echo form_submit ("submit","хайх",array("class"=>"btn btn-primary")); ?>
    <? echo form_close();?>
  </div>
</div>





<div class="panel panel-default">
  <div class="panel-heading">Админы цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
  <li class="list-group-item">
    <?=anchor("admin/customers","Хэрэглэгч хайх");?>
  </li>
  
	<li class="list-group-item">
    <?=anchor("admin/customers_insert","Үйлчлүүлэгч бүртгэх");?>
  </li>
  
  <li class="list-group-item">
    <?=anchor("admin/customers_import","Үйлчлүүлэгч файлаас импортлох");?>
  </li>
  
    <!--li class="list-group-item">
    <? //anchor("admin/customers_all","Бүх хэрэглэгчийг харах");?>
  </li-->
  
</ul>
  </div>
</div>



	<div class="panel panel-default">
  <div class="panel-heading">Тусламж</div>
  <div class="panel-body">
	<? $this->load->view("page2");?>

  </div><!-- panel-body -->
  </div><!-- panel --> 