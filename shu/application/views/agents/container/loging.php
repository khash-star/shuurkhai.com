<? 
 $container_id=$_POST["container_id"];
 $date=$_POST["date"];
 $description=$_POST["description"];

$data = array(
               'container' => $container_id,
               'date' => $date,
               'description' =>$description,
               'agent' => $this->session->userdata("agent_id"),
			   'timestamp'=>date("Y-m-d H:i:s")
            );
	if($this->db->insert('container_log', $data)) 
		{
			redirect("agents/container_detail/".$container_id);
		}
	else echo $this->db->_error_message();
?>