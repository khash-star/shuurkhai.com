<div class="panel panel-success">
  <div class="panel-heading">Box үүсгэх</div>
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
			   'status'=>'new'
            );
	if($this->db->insert('boxes', $data)) 
		{
		$box_id= $this->db->insert_id()  ;
		echo '<div class="alert alert-success" role="alert">Амжилттай нэмэгдлээ</div>';
		echo anchor("agents/boxes_fill/".$box_id,"Fill box",array('class'=>'btn btn-primary btn-xs'));		
		}
	}else echo '<div class="alert alert-danger" role="alert">BOX-н нэр давхацаж байна.</div>';
 }
 else echo '<div class="alert alert-danger" role="alert">Хоосон утга байж болохгүй.</div>';
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?=anchor("agents/boxes","Boxes",array('class'=>'btn btn-primary'));		