<?

	$saved=$this->session->userdata('saved'); 
 	//$this->session->sess_destroy();
/*if ($this->session->userdata('saved')!="") 
	{
	$this->session->sess_destroy();
	$newdata = array(
                   'saved'  => $saved);
	$this->session->set_userdata($newdata);
	}
	else $this->session->sess_destroy();
;
*/
$newdata = array(
                   'login'  => FALSE,
				   'admin_login'  => FALSE,
                   'timestamp'     => "",
                   'logged_user' => "",
				   'logged_name' => "",
				   'logged_pass' => "",
				   'agent_login'  => FALSE,
                   'agent_timestamp'     => "",
				   'logged_name'     => "",
                   'agent_logged_user' => "",
				   'agent_logged_pass' => "",
				   'agent_id' =>"",
                   'customer_login'  => FALSE,
                   'customer_timestamp' => "",
				   'logged_name'     => "",
				   'customer_id' =>"",
				   'saved' => $saved
               );
$this->session->set_userdata($newdata);

//echo $this->session->userdata('saved'); 
//$this->session->userdata('login') = FALSE;
log_write("Administrator амжилттай гарлаа","logout");
redirect('welcome', 'refresh');

?>