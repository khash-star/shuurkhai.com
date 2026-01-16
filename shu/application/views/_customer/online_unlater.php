<? if (!$this->uri->segment(3)) redirect('customer/online'); else $online_id=$this->uri->segment(3) ?>


<div class="panel panel-default">
  <div class="panel-heading">Захиалга хойшлуулах</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');

$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
		if ($this->db->query("UPDATE online SET status='online' WHERE online_id=".$online_id))
		redirect("customer/online");
		else echo "Алдаа гарлаа: ";
	}
	else echo '<div class="alert alert-success" role="alert">Таны оруулсан захиалга биш байна.</div>';
}
else //if ($query->num_rows() == 1)
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
?>
<br />


  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<a href="<?=base_url();?>index.php/welcome/faqs" class="btn btn-warning">Түгээмэл асуултууд</a>

<a href="<?=base_url();?>index.php/welcome/tutor" class="btn btn-warning">Заавар</a>