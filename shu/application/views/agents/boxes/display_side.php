<? 
// $customer_id = $this->session->userdata('agent_id');
// if (isset($_POST["search"])) $search=$_POST["search"]; else $search="";
?>

<div class="panel panel-default">
  <div class="panel-heading">Agent menu</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("agents/boxes","Active boxes");?>
  </li>
    <li class="list-group-item">
   	<? 	
	  echo anchor("agents/boxes_create","Box create");?>
  </li>

  </li>
    <li class="list-group-item">
   	<? 	
	  echo anchor("agents/boxes_package_list_create","Packaging list create");
    ?>
  </li>

  </li>
    <li class="list-group-item">
   	<? 	
    echo anchor(base_url().'assets/xlsx/boxes_package.xlsx', 'Packaging list print');
    ?>


  </li>
 
  <!--li class="list-group-item">
    <? //anchor("agents/boxes_history","Boxes түүх");?>
  </li-->
  
</ul>
  </div>
</div>