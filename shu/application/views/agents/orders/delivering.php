<? if (!$this->uri->segment(3)) redirect('orders/display'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
echo "<h3>Илгээмж хүргэлт</h3>";
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
    $this->db->where('order_id', $order_id);
		$data = array(
               'status' => "delivered"
            		  );
	if ($this->db->update('orders', $data)) 
	echo "Илгээмж хүргэгдлээ"; 
	else echo "ERROR".$this->db->error();
  
} 
else 
echo "Илгээмж олдсонгүй<br>";

?>

</div>
<div id="right_side">
<? $this->load->view("calendar");?>
<div id="side_menu">
<ul>
<li><?=anchor('agents', 'Home')?></li>
<li><?=anchor('agents/create', 'Илгээмж оруулах')?></li>
</ul>
</div> <!--side_menu-->
</div> <!--right_side-->
<div id="clear"></div>
</div><!--wrapper-->