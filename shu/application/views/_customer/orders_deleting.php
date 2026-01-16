<? if (!$this->uri->segment(3)) redirect('customer/orders'); else $orders_id=$this->uri->segment(3) ?>
<div class="panel panel-default">
  <div class="panel-heading">Илгээмж устгах</div>
  <div class="panel-body">
<? 
$customer_id = $this->session->userdata('customer_id');

$query = $this->db->query("SELECT * FROM orders WHERE order_id=".$orders_id);

if ($query->num_rows() == 1)
	{
		$row = $query->row();
		if ($row->status=="weight_missing" && $row->owner==1)
		{
		if ($row->sender==$customer_id || $row->receiver==$customer_id)
		{
		$sql="DELETE FROM orders WHERE order_id=$orders_id";
		if ($this->db->query($sql))
		{
			echo '<div class="alert alert-success" role="alert">Илгээмжийг устгалаа.</div>';
			$this->db->query("UPDATE customer SET cent=cent-1 WHERE customer_id='$customer_id'");
		}
		else echo '<div class="alert alert-danger" role="alert">Илгээмжийг устгахад алдаа гарлаа.</div>';
		}
		else  //$row->sender==$customer_id || $row->receiver==$customer_id
		echo '<div class="alert alert-danger" role="alert">Таны илгээмж биш байна.</div>';
	}
	else //$row->status=="weight_missing"
	echo '<div class="alert alert-danger" role="alert">Илгээмж манайх салбарт ирсэн учираас устгах боломжгүй.</div>';
	}
else //$query->num_rows() == 1
echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй.</div>';

?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("customer/orders","Миний илгээмжүүд",array("class"=>"btn btn-success"));?>
