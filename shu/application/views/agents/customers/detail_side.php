<? 
 $agent_id = $this->session->userdata('agent_id');
 	if ($this->uri->segment(3)) $customer_id=$this->uri->segment(3);
	if (isset($_POST["customer_id"])) $customer_id=$_POST["customer_id"];
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
  
  <li class="list-group-item">
   	<? 	
	echo anchor("agents/customers_edit/".$customer_id,"Мэдээллийг засах");?>
  </li>
  
  <li class="list-group-item">
   	<? 
	$sql= "SELECT * FROM orders WHERE (receiver=".$customer_id." OR sender=".$customer_id." OR deliver=".$customer_id.") AND status='delivered'";
	$query = $this->db->query($sql);
	echo  "<span class='badge'>".$query->num_rows()."</span>";
	
	echo anchor("agents/history","Хэрэглэгчийн түүх");?>
  </li>
</ul>
  </div>
</div>