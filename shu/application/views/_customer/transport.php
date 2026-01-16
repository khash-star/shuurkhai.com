<? if (!$this->uri->segment(3)) redirect('customer/orders'); else $order_id=$this->uri->segment(3) ?>

<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM orders WHERE order_id=$order_id";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->receiver==$customer_id || $row->sender==$customer_id || $row->deliver==$customer_id)
	{
	
	$transport = $row->transport;
	if ($transport==1)
		$this->db->query("UPDATE orders SET transport=0 WHERE order_id=$order_id");
	if ($transport==0)
		$this->db->query("UPDATE orders SET transport=1 WHERE order_id=$order_id");
		redirect("customer/orders");
	}
	else redirect("customer/orders");
}
else redirect("customer/orders");