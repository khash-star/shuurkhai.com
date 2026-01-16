<? if (!$this->uri->segment(3)) redirect('agents/container'); else $item_id=$this->uri->segment(3);?>


<div class="panel panel-default">
  <div class="panel-heading">Илгээмж устгах</div>
  <div class="panel-body">
<? 
$agent_id=$this->session->userdata("agent_id");

$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);

if ($query->num_rows() == 1)
	{
		$row = $query->row();
		if ($row->status=="weight_missing" && $row->owner==2 && $row->agent == $agent_id)
				{
					$sql="DELETE FROM container_item WHERE id=$item_id";
					if ($this->db->query($sql))
					{
					echo '<div class="alert alert-success" role="alert">Ачааг устгалаа.</div>';
					$this->db->query("UPDATE customer SET cent=cent-1 WHERE customer_id='$customer_id'");
					}
					else echo '<div class="alert alert-danger" role="alert">Ачааг устгахад алдаа гарлаа.</div>';
				}
				else //$row->status=="weight_missing"
				echo '<div class="alert alert-danger" role="alert">Ачаа таны оруулсан ачаа биш учираас устгах боломжгүй.</div>';
	}
	else //$query->num_rows() == 1
	echo '<div class="alert alert-danger" role="alert">Ачаа олдсонгүй.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("agents/container","Чингэлэг",array("class"=>"btn btn-success"));?>