<? if (!$this->uri->segment(3)) redirect('agents/container'); else $item_id=$this->uri->segment(3);?>


<div class="panel panel-default">
  <div class="panel-heading">Илгээмж чингэлэгээс гаргах</div>
  <div class="panel-body">
<? 
$agent_id=$this->session->userdata("agent_id");

$query = $this->db->query("SELECT * FROM container_item WHERE id=".$item_id);

if ($query->num_rows() == 1)
	{
		$row = $query->row();
		if ($row->status=="new" || $row->status == "")
				{
					$sql="UPDATE container_item SET container=0 WHERE id=$item_id";
					if ($this->db->query($sql))
					{
					echo '<div class="alert alert-success" role="alert">Ачааг гаргалаа.</div>';

					}
					else echo '<div class="alert alert-danger" role="alert">Ачааг гаргахад алдаа гарлаа.</div>';
				}
				else //$row->status=="weight_missing"
				echo '<div class="alert alert-danger" role="alert">Ачаа гарсан учираас гаргах боломжгүй.</div>';
	}
	else //$query->num_rows() == 1
	echo '<div class="alert alert-danger" role="alert">Ачаа олдсонгүй.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->


<?=anchor("agents/container","Чингэлэг",array("class"=>"btn btn-success"));?>