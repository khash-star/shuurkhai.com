<? 
$customer_id = $this->session->userdata('agent_id');
if ($this->uri->segment(3)) $order_id=$this->uri->segment(3);
?>

<div class="panel panel-default">
  <div class="panel-heading">Агентийн цэс</div>
  <div class="panel-body">
  
  <ul class="list-group">
	<li class="list-group-item"><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
	<!--li><? //anchor(base_url().'assets/orders.xlsx', 'Excel файл татах')?></li-->
<li  class="list-group-item"><?=anchor('agents/tracks', 'Tracks')?></li>
<li  class="list-group-item"><?=anchor('agents/tracks_insert', 'Track оруулах')?></li>
<? if (isset($order_id))
	{
	$query = $this->db->query("SELECT * FROM orders WHERE order_id=$order_id LIMIT 1");
	if ($query->num_rows())
	{
	$row=$query->row();
	$status=$row->status;
	$weight=$row->weight;
	$owner=$row->owner;
	if ($status!="weight_missing"&&$status!="order")
	{
	echo "<li  class='list-group-item'>".anchor('agents/tracks_preview/'.$order_id,'Хэвлэх CP72',array('target'=>"_blank"))."</li>";
	echo "<li  class='list-group-item'>".anchor('agents/tracks_mini/'.$order_id,'Хэвлэх Mini',array('target'=>"_blank"))."</li>";
	}
	if ($status=="new")
	{
	echo "<li  class='list-group-item'>".anchor('agents/tracks_clear_weight/'.$order_id,'Жинг цэвэрлэх')."</li>";
	}
	if ($status=="order" || ($status=="new" && $owner=2) || ($status=="item_missing" && $owner=2)) //able to delete own track
	echo "<li  class='list-group-item'>".anchor('agents/tracks_deleting/'.$order_id,'Устгах')."</li>";
   	//echo "<li>".anchor('online_orders/track/'.$order_id,'Хаана явна')."</li>";
   	if (($status=="item_missing" && $owner=2)) //able to delete own track
	echo "<li  class='list-group-item'>".anchor('agents/tracks_edit/'.$order_id,'Засах')."</li>";
	}


	}
?>

</ul>
</ul>
  </div>
</div>