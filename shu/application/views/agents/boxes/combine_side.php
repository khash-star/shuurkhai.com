<? 
$customer_id = $this->session->userdata('agent_id');
$box_id=$this->uri->segment(3);
?>

<div class="panel panel-default">
  <div class="panel-heading">Agent menu</div>
  <div class="panel-body">
  
  <ul class="list-group">
  	<li class="list-group-item">
   	<? 	
	echo anchor("agents/combine_display","Combined box");?>
  </li>
	<li class="list-group-item">
   	<? 	
	echo anchor("agents/boxes_combine","Combine");?>
  </li>
  <? if ($this->uri->segment(3)) {?>
	<li class="list-group-item">
    <?=anchor("agents/combine_preview/".$this->uri->segment(3),"combined CP72",array("target"=>"_blank"));?>
  </li>
  <? }?>
  </ul>
  </div>
</div>