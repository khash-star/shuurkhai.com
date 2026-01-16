<? if (!$this->uri->segment(3)) redirect('boxes'); else $box_id=$this->uri->segment(3) ?>

<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
$query=$this->db->query("SELECT * FROM boxes WHERE box_id='".$box_id."'");
if ($query->num_rows()>0)
{
	$row_box = $query->row();
	$box_status= $row_box -> status;
	if ($box_status=='new')
		{
		$data = array('status' => 'closed');
		$this->db->where('box_id', $box_id);
		$this->db->update('boxes', $data);
		echo '<div class="alert alert-success" role="alert">Box closed</div>';
		echo "<br>".anchor('agents/boxes_preview/'.$box_id, 'Print',array('target'=>"new",'class'=>'btn btn-primary btn-xs'));
		}
		else echo '<div class="alert alert-danger" role="alert">Box isn\'t ready for close or closed already</div>';
	}
	else echo '<div class="alert alert-danger" role="alert">Box олдсонгүй</div>';
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?=anchor('agents/boxes/', 'Boxes',array('class'=>'btn btn-primary'));