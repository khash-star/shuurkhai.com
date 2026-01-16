<div class="panel panel-success">
  <div class="panel-heading">Чингэлэг үүсгэх</div>
  <div class="panel-body">
<? 
 $name=date("Y.m.d");
// $expected=$_POST["expected"];
 $description=$_POST["description"];

$data = array(
               'name' => $name,
               'created' => date("Y-m-d H:i:s"),
			  // 'expected' => $expected,
               'description' =>$description,
               'agent' => $this->session->userdata("agent_id"),
			   'status'=>'new'
            );
	if($this->db->insert('container', $data)) 
		{
		$container= $this->db->insert_id()  ;
		echo '<div class="alert alert-success" role="alert">Амжилттай нэмэгдлээ</div>';
		echo anchor("agents/container_item_insert/".$container,"Ачаа оруулах",array('class'=>'btn btn-primary btn-xs'));		
		}

 
?>
  </div> <!-- PANEL BODY -->
</div><!-- PANEL  -->
<?=anchor("agents/container","Чингэлэгүүд",array('class'=>'btn btn-primary'));		