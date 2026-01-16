<? if (!$this->uri->segment(3)) redirect('agents/tracks_insert'); else $order_id=$this->uri->segment(3) ?>

<div class="panel panel-primary">
  <div class="panel-heading">Track: цэвэрлэх</div>
  <div class="panel-body">
<? 	

		$query = $this->db->query("SELECT * FROM orders WHERE order_id='$order_id'");
		$row = $query->row();
		$current_status=$row->status;
		$weight=$row->weight;
        

        if ($current_status =="item_missing")
        {
            $query_proxies = $this->db->query('DELETE FROM orders WHERE order_id="'.$order_id.'" LIMIT 1');
        }
			
	redirect("agents/tracks_insert");
?>

</div> <!-- PANEL-BODY -->
</div><!-- PANEL -->