<? 
//$customer_id = $this->session->userdata('agent_id');
if ($this->uri->segment(3)) $order_id=$this->uri->segment(3);
if (isset($_POST["order_id"])) $order_id=$_POST["order_id"];
?>





<div class="panel panel-default">
  <div class="panel-heading">Админ цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
 	 <li class="list-group-item"><?=anchor('admin/orders', 'Бүх илгээмж')?></li>
	<li class="list-group-item"><?=anchor('admin/create', 'Илгээмж оруулах')?></li>
	
	<? 
	$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
	$query = $this->db->query($sql);
	
	if($query->num_rows()==1)
	{
	{
	$row = $query ->row();
	if ($row ->status!="order")
	echo '<li class="list-group-item">'.anchor('admin/preview/'.$order_id,'Хэвлэх',array('target'=>"new")).'</li>';
    echo '<li class="list-group-item">'.anchor('admin/deleting/'.$order_id,'Устгах').'</li>';
	echo '<li class="list-group-item">'.anchor('admin/edit/'.$order_id,'засах').'</li>';
	}
	}
?>

</ul>
</ul>
  </div>
</div>