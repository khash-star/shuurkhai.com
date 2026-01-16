<? if (!$this->uri->segment(3)) redirect('admin/orders'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Илгээмжийн устгах</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
    if($this->db->query("DELETE FROM orders WHERE order_id=".$order_id))
	echo '<div class="alert alert-success" role="alert">Захиалгыг амжилттай устгалаа.</div>';
	else echo '<div class="alert alert-danger" role="alert">Алдаа.'.$this->db->error.'</div>';
  
} 
else 
echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</div>';

?>

</div>
</div>