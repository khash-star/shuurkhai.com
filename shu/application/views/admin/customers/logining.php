<div class="panel panel-primary">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">

<?
$tel=$_POST["tel"];
$pass=$_POST["pass"];

$sql="SELECT * FROM customer WHERE tel='$tel' AND password='$pass' LIMIT 1";
$query=$this->db->query($agent_sql);
	if ($query->num_rows() == 1)
	{ // LOGINING
	$row=$query->row();
	$user_id=$row->customer_id;
	$agent_name=$row->name;
	$this->db->query("UPDATE customer SET last_log='".date("Y-m-d h:i:s")."' WHERE customer_id='$user_id' LIMIT 1");
	$newdata = array(
                   'agent_login'  => TRUE,
                   'agent_timestamp'     => date("Y-m-d h:i:s"),
				   'logged_name'     => $agent_name,
                   'agent_logged_user' => $username,
				   'agent_logged_pass' =>md5($pass),
				   'agent_id' =>$agent_id
               );
	 $this->session->set_userdata($newdata);
	 
	echo "Agent $agent_name loggin in";
	redirect('agents', 'refresh',5);
	}
	else redirect('welcome/login', 'refresh');
}
?>

</div>
<div id="clear"></div>
</div><!--wrapper-->