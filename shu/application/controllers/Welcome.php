<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'home_content';
		$data['right_side'] = 'right_side';
		
		/*$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
			$data['content'] = 'admin/home_content';
			$data['right_side'] = 'admin/right_side';
		}
		
		if ($this->session->userdata('agent_login'))
		{
			$data['content'] = 'agents/home_content';
			$data['right_side'] = 'agents/right_side';
		}
		
		if ($this->session->userdata('customer_login'))
		{
			$data['content'] = 'customer/home_content';
			$data['right_side'] = 'right_side';
		}
		*/
		
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	
	public function online()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function about()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'pages/about';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function track_insert()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'track_insert';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
	
	
	public function track_register()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'track_register';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
		public function tracks_password_check()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'tracks_password_check';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
			public function tracks_completing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'tracks_completing';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	

	
	public function order_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'order_create';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	
	public function location()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'location';
		$data['right_side'] = 'right_side';
		
		
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	
	public function login()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'login';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function logining()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'logining';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function logout()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'logout';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function register()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'register';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function registering()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'registering';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function test()
	{	
		$this->load->view('test');
	}
	public function calculator()
	{	$this->load->view('header');
		$this->load->view('top_menu');		
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'calculator';
		$data['right_side'] = 'customer/customer_side';
		}
		else 		
		{
		$data['content'] = 'calculator';
		$data['right_side'] = 'right_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function help()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'help';
		$data['right_side'] = 'customer/customer_side';
		}
		else 		
		{
		$data['content'] = 'help';
		$data['right_side'] = 'right_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function faqs()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'faqs';
		$data['right_side'] = 'customer/customer_side';
		}
		else 		
		{
		$data['content'] = 'faqs';
		$data['right_side'] = 'right_side';
		}		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function helping()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'helping';
		$data['right_side'] = 'customer/customer_side';
		}
		else 		
		{
		$data['content'] = 'helping';
		$data['right_side'] = 'right_side';
		}		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function uploader()
	{	
		$this->load->view('uploader');
	}
	
	public function tutor()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('customer_login'))
		{
		$data['content'] = 'tutorial';
		$data['right_side'] = 'customer/customer_side';
		}
		else 		
		{
		$data['content'] = 'tutorial';
		$data['right_side'] = 'right_side';
		}		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
	public function track_search()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'track_search';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function track_searching()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'track_searching';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function online_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online_creating';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
		public function online_creating2()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online_creating2';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function online_creating3()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online_creating3';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function online_registering()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online_registering';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function online_completing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'online_completing';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	
	public function transport()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'transport';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function transport_checking()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'transport_checking';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function transport_checking2()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'transport_checking2';
		$data['right_side'] = 'right_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	public function amazon_track()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$data['content'] = 'amazon_track';
		$data['right_side'] = 'right_side';		
		$this->load->view('content',$data);
		$this->load->view('footer');
		
		
	}	
	
	
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */