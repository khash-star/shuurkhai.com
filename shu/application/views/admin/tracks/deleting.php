<? if (!$this->uri->segment(3)) redirect('admin/tracks'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Track:Deleting</div>
  <div class="panel-body">
<? 
//$agent_id= $this->session->userdata("agent_id");
$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$order_id);

if ($query->num_rows() == 1)
{
    if($this->db->query("DELETE FROM orders WHERE order_id=".$order_id))
	echo "Захиалгыг амжилттай устгалаа.<br>";
	else echo "Алдаа.".$this->db->error."<br>";
  
} 
else 
echo "Илгээмж олдсонгүй<br>";

?>

</div>
</div>
