<div class="panel panel-success">
  <div class="panel-heading">Shuurkhai.Com</div>
  <div class="panel-body">

<?
$username=$_POST["username"];
$pass=$_POST["pass"];
if ($username==cfg_param("admin_username")&&$pass==cfg_param("admin_password"))
{
	$newdata = array(
                  'login'  => TRUE,
				   'admin_login'  => TRUE,
                  'timestamp'     => date("Y-m-d h:i:s"),
                  'logged_user' => $username,
				   'logged_name' => "Administrator"
				   //'logged_pass' =>md5($pass)
              );
  	 if (isset($_POST["saved"])) $newdata['saved'] = $username; else $newdata['saved']="";
	 $this->session->set_userdata($newdata);
	 log_write("Admin ".$username." амжилттай нэвтэрлээ","login");
	 echo "Admin logging in";
	 redirect('admin', 'refresh',5);
//echo "Logging";
}
else 
{
$agent_sql="SELECT * FROM agents WHERE username='$username' AND password='$pass' LIMIT 1";
$query=$this->db->query($agent_sql);
	if ($query->num_rows() == 1)
	{
	$row=$query->row();
	$agent_id=$row->agent_id;
	$agent_name=$row->name;
	$this->db->query("UPDATE agents SET last_log='".date("Y-m-d h:i:s")."' WHERE agent_id='$agent_id' LIMIT 1");
	$newdata = array(
					'login'  => TRUE,
                   'agent_login'  => TRUE,
                   'agent_timestamp'     => date("Y-m-d h:i:s"),
				   'logged_name'     => $agent_name,
                   'agent_logged_user' => $username,
				   //'agent_logged_pass' =>md5($pass),
				   'agent_id' =>$agent_id
               );
		   
	if (isset($_POST["saved"])) $newdata['saved'] = $username; else $newdata['saved']="";
	 $this->session->set_userdata($newdata);
	 
	echo "Agent $agent_name loggin in";
	redirect('agents', 'refresh',5);
	}
	/*else 
	{
		$customer_sql="SELECT * FROM customer WHERE username='$username' AND password='$pass' LIMIT 1";
		$query=$this->db->query($customer_sql);
		if ($query->num_rows() == 1)
		{
		$row=$query->row();
		$customer_id=$row->customer_id;
		$customer_name=$row->name;
		$this->db->query("UPDATE customer SET last_log='".date("Y-m-d h:i:s")."' WHERE customer_id='$customer_id' LIMIT 1");
		$newdata = array(
					   'login'  => TRUE,
	                   'customer_login'  => TRUE,
	                   'customer_timestamp'     => date("Y-m-d h:i:s"),
					   'logged_name'     => $customer_name,
	                   //'agent_logged_user' => $username,
					   //'agent_logged_pass' =>md5($pass),
					   'customer_id' =>$customer_id
	               );
		if (isset($_POST["saved"])) $newdata['saved'] = $username; else $newdata['saved']="";
		 $this->session->set_userdata($newdata);
		 echo "$customer_name нэвтэрч байна.";
		 if($username==$pass)
		 redirect('customer/profile_password', 'refresh',5);
		else 
				{
					$sql= "SELECT * FROM help WHERE receiver='".$customer_id."' AND `read`='0'";
					$query = $this->db->query($sql);
					if ($query->num_rows()>0)
					{ redirect('customer/help', 'refresh',5);
					}
					else redirect('customer', 'refresh',5);
				}
		}
		else 
		{
		$customer_sql="SELECT * FROM customer WHERE username='$username' LIMIT 1";
		$query=$this->db->query($customer_sql);
		if ($query->num_rows() == 1)
		redirect('welcome/login/error', 'refresh');
		else 
		redirect('welcome/register/'.$username, 'refresh');
		}
	}
	*/
}
?>

</div>
<div id="clear"></div>
</div><!--wrapper-->