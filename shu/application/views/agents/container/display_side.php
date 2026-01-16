<? 
// $customer_id = $this->session->userdata('agent_id');
// if (isset($_POST["search"])) $search=$_POST["search"]; else $search="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("agents/boxes","Boxes идэвхитэй");?>
  </li>
    <li class="list-group-item">
   	<? 	
	  echo anchor("agents/boxes_create","Box үүсгэх");?>
  </li>

  </li>
    <li class="list-group-item">
   	<? 	
	  echo anchor("agents/boxes_package_list_create","Packaging list үүсгэх");
    ?>
  </li>

  </li>
    <li class="list-group-item">
   	<? 	
	  echo anchor("agents/boxes_package_list_create","Packaging list хэвлэх");
    ?>
  </li>
 
  <!--li class="list-group-item">
    <? //anchor("agents/boxes_history","Boxes түүх");?>
  </li-->
  
</ul>
  </div>
</div>