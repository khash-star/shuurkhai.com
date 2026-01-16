<?
$username=$this->session->userdata('agent_logged_user');
$query=$this->db->query("SELECT name FROM agents WHERE username='$username' LIMIT 1");
   	$row = $query->row();
	$name=$row->name;
$this->session->sess_destroy();
log_write("Agent ".$name." амжилттай гарлаа","logout");
redirect('welcome', 'refresh');

?>