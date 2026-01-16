<? if (!$this->uri->segment(3)) redirect('admin/online'); else $online_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Online захиалга: Pending</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	$data = $query->row();
	echo $data->status;
	if ($data->status=="pending")
		{
		$this->db->query("UPDATE online SET status='regular' WHERE online_id=".$online_id);
		echo '<div class="alert alert-success" role="alert">Online захиалгыг төлөвт өөрчлөлт орлоо.</div>';
	//else echo '<div class="alert alert-success" role="alert">Алдаа.'.$this->db->error.'</div>';
		redirect("admin/online_pendings"); 
		}
	
	if ($data->status=="online" || $data->status=="regular")
    	{
		$this->db->query("UPDATE online SET status='pending' WHERE online_id=".$online_id);
		echo '<div class="alert alert-success" role="alert">Online захиалгыг төлөвт өөрчлөлт орлоо.</div>';
	//else echo '<div class="alert alert-success" role="alert">Алдаа.'.$this->db->error.'</div>';
		redirect("admin/online"); 
		}
		 
} 
else 
echo '<div class="alert alert-success" role="alert">Online Илгээмж олдсонгүй</div>';

?>

</div>
</div>
