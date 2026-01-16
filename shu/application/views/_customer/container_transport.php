<? if (!$this->uri->segment(3)) redirect('customer/container'); else $item_id=$this->uri->segment(3) ?>

<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM container_item WHERE id=$item_id";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{
	
	$transport = $row->transport;
	if ($transport==1)
		$this->db->query("UPDATE container_item SET transport=0 WHERE id=$item_id");
	if ($transport==0)
		$this->db->query("UPDATE container_item SET transport=1 WHERE id=$item_id");
	}
}

redirect("customer/container");
