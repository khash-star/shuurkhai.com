<div class="panel panel-primary">
  <div class="panel-heading">Гардуулсан тракыг засах</div>
  <div class="panel-body">
  	 Трак давхцалтай үед хуучин тракыг засах боломжтой.
<? 
	if (!$this->uri->segment(3)) redirect('admin/tracks'); else $order_id=$this->uri->segment(3);

	$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
	$query = $this->db->query($sql);
	
	if($query->num_rows()==1)
	{
		$row = $query->row();
	echo form_open ("admin/tracks_modifying");
	echo form_hidden("order_id",$order_id);
	echo "Одоогийн :". form_input("old track",$row->third_party,array("class"=>"form-control","readonly"=>"readonly"));
	echo "Шинэ :".form_input("new",$row->third_party,array("class"=>"form-control","required"=>"required","autofocus"=>"autofocus"));
	echo form_submit("submit","Засах",array("class"=>"btn btn-success"));
	echo form_close();

	}
	else echo "Дугаар буруу";


?>

</div>
</div>