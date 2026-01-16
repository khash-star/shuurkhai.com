<? if (!$this->uri->segment(3)) redirect('agents/orders'); else $order_id=$this->uri->segment(3) ?>

<script>
$(document).ready(function(e) {
    $("input[name='barcode']").focus();
});
</script>

<div class="panel panel-primary">
  <div class="panel-heading">Track</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT * FROM orders WHERE is_online=1 AND  order_id=".$order_id);

if ($query->num_rows() == 1)
{	
	$row = $query->row();
	$track =$row->third_party;
	if ($row->status=='new')
			{
			$this->db->query("UPDATE orders SET status='weight_missing',weight=NULL, advance_value=NULL WHERE order_id=".$order_id);
	
			log_write("Order weight clear id =$order_id ".json_encode($query->result()),"order weight clear");

			echo form_open('agents/tracks_checking2');
			echo "<table class='table table-hover'>";
			echo form_hidden("track",$track);
			echo "<tr><td>Weight /KG/</td><td>".form_input("weight","",array("class"=>"form-control","placeholder"=>"Eg:5.4"))."</td></tr>";
			echo "</table>";
			echo form_submit("submit","add",array("class"=>"btn btn-success"));
	
			echo form_close();
			}
		else echo "New төлөвт биш учир жинг цэвэрлэх боломжгүй";
}
?>

  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?=anchor("agents/tracks","All track",array("class"=>"btn btn-primary"));?>