<? if (!$this->uri->segment(3)) redirect('agents/orders'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Илгээмжийн устгах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{	
	$row = $query->row();
		if ($row->agents==$this->session->userdata("agent_id")&&$row->status=='new')
			{
			log_write("Order delete id =$order_id ".json_encode($query->result()),"order delete");
			if($this->db->query("DELETE FROM orders WHERE order_id=".$order_id))
			echo '<div class="alert alert-success" role="alert">Захиалгыг амжилттай устгалаа.</div>';
			else echo '<div class="alert alert-danger" role="alert">Алдаа.'.$this->db->error.'</div>';
			}
			else echo "Устгах эрхгүй";
  
} 
else 
echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';

?>

</div>
</div>