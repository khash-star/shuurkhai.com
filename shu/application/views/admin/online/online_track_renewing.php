<? if (!isset($_POST["online_id"])) redirect('admin/online'); else $online_id=$_POST["online_id"]; ?>
<div class="panel panel-primary">
  <div class="panel-heading">Track оруулах</div>
  <div class="panel-body">
<? 
		$error=TRUE;
		$query = $this->db->query("SELECT * FROM online WHERE online_id='".$online_id."'");
		if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$online_id=$row->online_id;
	
		$track = $_POST["track"];
		$track = string_clean($track);
		
			if($this->db->query("UPDATE online SET status='order',track='$track',proceed_date='".date("Y-m-d H:i:s")."' WHERE online_id='$online_id' LIMIT 1"))
			echo '<div class="alert alert-success" role="alert">Илгээмжинд нэгтгэлээ</div>';
			
			else 
			{
			echo '<div class="alert alert-danger" role="alert">Error:'.$this->db->error().'</span>';
			}
		}
		else echo '<div class="alert alert-danger" role="alert">Илгээмж олдсонгүй</span>';
?>

</div>
</div>
<?=anchor("admin/online","Бүх online захиалгууд",array("class"=>"btn btn-primary"));?>