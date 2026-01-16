<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracks extends CI_Controller {

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
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{$this->load->view('header');
		$data['content'] = 'tracks/display';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
		
	}		
	public function display_search()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header_empty');
		$data['content'] = 'tracks/display_search';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
		}
	}
	
		public function insert()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/insert';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function checking()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/checking';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function checking2()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/checking2';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function checking3()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'tracks/checking3';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function checking4()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/checking4';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
		public function check()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header_empty');
		$data['content'] = 'tracks/check';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
		}
	}
	
	public function adding()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/adding';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	public function edit()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'tracks/edit';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function editing()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'tracks/editing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function detail()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/detail';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
		public function changing()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/changing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function deleting()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'tracks/deleting';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	
	public function preview()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		//$this->load->view('header');
		$data['content'] = 'tracks/preview';
		$this->load->view('content',$data);
		//$this->load->view('footer');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */