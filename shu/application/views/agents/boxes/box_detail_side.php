<? 
$customer_id = $this->session->userdata('agent_id');
$box_id=$this->uri->segment(3);
?>

<div class="panel panel-default">
  <div class="panel-heading">Agent menu</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item">
    <?=anchor("agents/boxes","Boxes");?>
  </li>
    <li class="list-group-item">
   	<? 	
	echo anchor("agents/boxes_create","Create box");?>
  </li>
  
  	<li class="list-group-item"><?=anchor('agents/boxes_fill/'.$box_id, 'Box fill')?></li>
    
     <li class="list-group-item">
   	<? 	
	echo anchor('agents/boxes_preview/'.$box_id,"Box badge",array("target" =>"new"));?>
  </li>
	<!--li class="list-group-item"><? //anchor('agents/boxes_preview/'.$box_id, 'Print',array('target'=>"new"))?></li-->
	<!--li class="list-group-item"><? //anchor(base_url().'assets/boxes_agent.xlsx', 'Excel файл татах')?></li-->
</ul>
  </div>
</div>