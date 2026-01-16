<?
if ($this->session->userdata('login')&&
	$this->session->userdata('logged_name')=="Administrator")
	{
		//ADMIN LOGGED IN
	}
	else 
	{
		if ($this->session->userdata('agent_login')&&
			$this->session->userdata('logged_name')!="")
		{	
			//AGENT LOGGED IN
		}
		else 
		{
		if ($this->session->userdata('customer_login')&&
			$this->session->userdata('logged_name')!="")
			{
				//CUSTOMER LOGGED IN
			}
			else 
			{}
		//LOGIN FAILED
		$this->session->sess_destroy();
		redirect("welcome/login","refresh");
		}
	
	}

?>