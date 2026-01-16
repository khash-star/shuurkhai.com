<? if (!$this->uri->segment(3)) redirect('agents/tracks'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Track устгах</div>
  <div class="panel-body">
<? 
$agent_id= $this->session->userdata("agent_id");
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);
	
if ($query->num_rows() == 1)
{
	$row = $query->row();
	$proxy_id =$row->proxy_id;
	$proxy_type =$row->proxy_type;
		if ($row->agents==$this->session->userdata("agent_id")&&($row->status=='new' || $row->status=='order'))
			{
			proxy_available($proxy_id,$proxy_type,0);
			log_write("Order delete id =$order_id ".json_encode($query->result()),"order delete");
			if($this->db->query("DELETE FROM orders WHERE agents='".$agent_id."' AND order_id=".$order_id))
			echo "Захиалгыг амжилттай устгалаа.<br>";
			else echo "Алдаа.".$this->db->error."<br>";
			}
			else echo "Устгах эрхгүй";
} 
else 
echo "Илгээмж олдсонгүй<br>";

?>

</div>
</div>