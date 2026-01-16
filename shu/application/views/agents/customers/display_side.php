<? 
$customer_id = $this->session->userdata('agent_id');
if (isset($_POST["search"])) $search =$_POST["search"]; else $search="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Шүүлтүүр</div>
  <div class="panel-body">
  
    <? echo form_open("agents/customers");?>
    <? echo form_input("search",$search,array("class"=>"form-control","placeholder"=>"хайх..."));?>
    <? echo form_submit ("submit","хайх",array("class"=>"btn btn-primary")); ?>
    <? echo form_close();?>
  </div>
</div>





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