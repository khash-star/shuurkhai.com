<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 /*  AGENT RELATED*/
	public function index()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');

	}	
	
	public function online_shops()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_shops';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	//PROFILE SECTION
	public function profile()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/profile';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function profile_password()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/profile_password';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
		public function profile_password_changing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/profile_password_changing';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
		public function profile_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/profile_edit';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
		public function profile_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/profile_editing';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	//PROFILE SECTION ENDING
	
	
	
	
	//ONLINE SECTION
		public function online()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	public function online_later()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_later';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_unlater()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_unlater';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_all_later()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_all_later';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	public function online_pending()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_pending';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function online_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_create';
		$data['right_side'] = 'customer/customer_side';
		}
		else 
		{
		$data['content'] = 'login';
		$data['right_side'] = 'customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_creating';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_edit';
		$data['right_side'] = 'customer/customer_side';
		}
		else 
		{
		$data['content'] = 'login';
		$data['right_side'] = 'customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_editing';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function online_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_deleting';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	public function online_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_history';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	


	public function online_transport()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/online_transport';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	//ONLINE SECTION ENDING
	
	
	
	
	//ORDER RELATED SECTION ENDING
		public function orders()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	public function orders_transport()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_transport';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	public function orders_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_create';
		$data['right_side'] = 'customer/customer_side';
		}
		else 
		{
		$data['content'] = 'login';
		$data['right_side'] = 'customer_side';
		}
		
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function orders_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_creating';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function orders_completing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_completing';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function orders_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_deleting';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	public function orders_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_history';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function orders_detail()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_detail';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function orders_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_edit';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	public function orders_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/orders_editing';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	

	//ORDER RELATED SECTION ENDING
	
	
	//HELP RELATED SECTION
	public function help()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/help';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/help_create';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/help_creating';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function help_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/help_history';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_read()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/help_read';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	//HELP RELATED SECTION ENDING
	
	
	
	
	//NEWS SECTION
	public function news()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/news';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	//NEWS SECTION ENDING
	
	
	
	
	//envoice SECTION
		public function envoice()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/envoice';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
		public function envoice_display()
	{
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$this->load->view('customer/envoice_display');
		}
		$this->load->view('footer_empty');
	}	
	
	public function envoices()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/envoices';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function envoices_display()
	{
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$this->load->view('customer/envoices_display');
		}
		$this->load->view('footer_empty');
		
	}	

	//envoice SECTION ENDING






	//CONTAINER RELATED SECTION ENDING
		public function container()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/container';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	public function container_transport()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/container_transport';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	
	
	public function container_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/container_deleting';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}

	public function container_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/container_history';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function container_detail()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'customer/container_detail';
		$data['right_side'] = 'customer/customer_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	//CONTAINER RELATED SECTION ENDING
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */