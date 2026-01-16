<? if (!$this->uri->segment(3)) redirect('customer/online'); else $online_id=$this->uri->segment(3) ?>
<div class="panel panel-default">
  <div class="panel-heading">Идэвхитэй захиалгууд</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');

$query = $this->db->query("SELECT * FROM online WHERE online_id=".$online_id);

if ($query->num_rows() == 1)
{
	
	$row = $query->row();
	if ($row->customer_id==$customer_id)
	{
	$sql="DELETE FROM online WHERE online_id='$online_id'";
	if ($this->db->query($sql))
	{
		echo '<div class="alert alert-success" role="alert">Захиалга устгалаа.</div>';
	}
	else //if ($row->customer_id==$customer_id)
 	echo '<div class="alert alert-danger" role="alert">Захиалга устгахад алдаа гарлаа.</div>';
	}
	else  //$row->customer_id==$customer_id
	 echo '<div class="alert alert-danger" role="alert">Таны оруулсан захиалга биш байна.</div>';
}
else //if ($query->num_rows() == 1)
echo '<div class="alert alert-danger" role="alert">Захиалга олдсонгүй.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("customer/online","Бусад захиалгууд",array("class"=>"btn btn-success"));?>
