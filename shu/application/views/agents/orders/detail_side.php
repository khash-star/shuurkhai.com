<? 
$customer_id = $this->session->userdata('agent_id');
if ($this->uri->segment(3)) $order_id=$this->uri->segment(3);
if (isset($_POST["order_id"])) $order_id=$_POST["order_id"];
?>





<div class="panel panel-default">
  <div class="panel-heading">Agent menu</div>
  <div class="panel-body">
  
  <ul class="list-group">
 	 <li class="list-group-item"><?=anchor('agents/orders', 'All orders')?></li>
	<li class="list-group-item"><?=anchor('agents/create', 'Place order')?></li>
	
	<? 
	$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
	$query = $this->db->query($sql);
	
	if($query->num_rows()==1)
	{
	{
	$row = $query ->row();
	if ($row ->status!="order")
	echo '<li class="list-group-item">'.anchor('agents/preview/'.$order_id,'Print',array('target'=>"new")).'</li>';
    echo '<li class="list-group-item">'.anchor('agents/deleting/'.$order_id,'Delete').'</li>';
	echo '<li class="list-group-item">'.anchor('agents/edit/'.$order_id,'Edit').'</li>';
	}
	}
?>

</ul>
</ul>
  </div>
</div>