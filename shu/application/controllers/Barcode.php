<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends CI_Controller {

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
		$data['content'] = 'barcode/home';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function insert()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{$this->load->view('header');
		$data['content'] = 'barcode/insert';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}	
		public function inserting()
	{
		$this->load->view('login_check');
		
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'barcode/inserting';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}	
	
	public function elimination()
	{
		$this->load->view('login_check');
		
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'barcode/elimination';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}	
	
	public function barcode_gen()
	{
		//$this->load->view('header');
		//$data['content'] = 'barcode/barcode_gen';
		$this->load->view('barcode/barcode_gen');
		//$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */