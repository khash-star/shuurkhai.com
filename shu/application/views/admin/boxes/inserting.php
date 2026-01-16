<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">
<? 
 $name=$_POST["box_name"];
 if ($name!="")
 {
  $query = $this->db->query("SELECT * FROM boxes WHERE name='$name'");
  if ($query->num_rows() == 0)
	{$data = array(
               'name' => $name,
			   'packages' => 0,
               'agent' => $this->session->userdata("agent_id"),
			   'status'=>'empty'
            );
	if($this->db->insert('boxes', $data)) 
		{
		$box_id= $this->db->insert_id()  ;
		echo "Successfully added<br>";
		echo anchor("boxes_fill/".$box_id,"Fill box");		
		}
	}else echo "Box already taken<br>";
 }
 else echo "Name shouldn't be empty<br>";
?>
</div>
<div id="clear"></div>
</div>