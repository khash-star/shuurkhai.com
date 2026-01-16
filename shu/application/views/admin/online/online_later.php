<? if (!$this->uri->segment(3)) redirect('admin/online'); else $online_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Online захиалга: Дараа болгох</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
    if($this->db->query("UPDATE online SET status='later' WHERE online_id=".$online_id))
	echo '<div class="alert alert-success" role="alert">Online захиалгыг амжилттай дараах болголоо.</div>';
	else echo '<div class="alert alert-success" role="alert">Алдаа.'.$this->db->error.'</div>';
	redirect("admin/online");  
} 
else 
echo '<div class="alert alert-success" role="alert">Online Илгээмж олдсонгүй</div>';

?>

</div>
</div>
