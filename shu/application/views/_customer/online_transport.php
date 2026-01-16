<? if (!$this->uri->segment(3)) redirect('customer/online'); else $online_id=$this->uri->segment(3) ?>

<? 
$customer_id = $this->session->userdata('customer_id');
$sql = "SELECT * FROM online WHERE online_id=$online_id";

$query = $this->db->query($sql);
if ($query->num_rows() == 1)
{
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
	
	$transport = $row->transport;
	if ($transport==1)
		$this->db->query("UPDATE online SET transport=0 WHERE online_id=$online_id");
	if ($transport==0)
		$this->db->query("UPDATE online SET transport=1 WHERE online_id=$online_id");
		redirect("customer/online");
	}
	else redirect("customer/online");
}
else redirect("customer/online");