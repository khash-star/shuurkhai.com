<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agents extends CI_Controller {

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

		$data['content'] = 'agents/home_content';
		$data['right_side'] = 'agents/right_side';

		$this->load->view('content',$data);
		$this->load->view('footer');

	}	
	
	public function commenting()
	{
		$this->load->view('header');
		$data['content'] = 'commenting';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	/*  ALL ABOUT ORDERS */
	public function orders()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/display_search';
		$data['right_side'] = 'agents/orders/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
		public function customers_check()
	{
		$this->load->view('agents/customers/check');
	}
	/*public function display()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/orders/display';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	public function display_search()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header_empty');
		$data['content'] = 'agents/orders/display_search';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
		}
	}*/
	public function detail()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/detail';
		$data['right_side'] = 'agents/orders/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}
	public function changing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/changing';
		$data['right_side'] = 'agents/orders/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function delete()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/delete';
		$data['right_side'] = 'agents/orders/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		
	public function deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/deleting';
		$data['right_side'] = 'agents/orders/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function preview()
	{
		//$this->load->view('login_check');
		//$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('agents/orders/preview');
		//$this->load->view('content',$data);
		}
	}
	
	public function create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/create';
		$data['right_side'] = 'agents/orders/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/orders/creating';
		$data['right_side'] = 'agents/orders/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function edit()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'agents/orders/edit';
		$data['right_side'] = 'agents/orders/detail_side';

		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
		public function editing()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/orders/editing';
		$data['right_side'] = 'agents/orders/detail_side';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	
	
	
	
	/*  ALL ABOUT TRACKS ORDERS */
	
	
	/*  ALL ABOUT TRACK */
		public function tracks()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/display_search';
		$data['right_side'] = 'agents/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	
	public function tracks_clear_weight()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/tracks_clear_weight';
		$data['right_side'] = 'agents/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}

	public function tracks_clean()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/tracks_clean';
		$data['right_side'] = 'agents/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	
	
	/*public function tracks_display()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/tracks/display';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function tracks_display_search()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header_empty');
		$data['content'] = 'agents/tracks/display_search';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
		}
	}
	*/
		public function tracks_insert()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/insert';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function tracks_de_insert()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/de_insert';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_checking()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/checking';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_checking2()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/checking2';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_checking3()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/checking3';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_checking4()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/checking4';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_checking5()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/checking5';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function tracks_check()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/check';
		$data['right_side'] = 'agents/tracks/tracks_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function tracks_adding()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/tracks/adding';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	public function tracks_edit()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'agents/tracks/edit';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function tracks_editing()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'agents/tracks/editing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function tracks_detail()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/detail';
		$data['right_side'] = 'agents/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function tracks_changing()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/tracks/changing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function tracks_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/deleting';
		$data['right_side'] = 'agents/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function tracks_preview()
	{
		$this->load->view('login_check');
		//$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		//$this->load->view('header');
		//$data['content'] = 'agents/tracks/preview';
		$this->load->view('agents/tracks/preview');
		//$this->load->view('footer');
		}
	}
	
	public function tracks_mini()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('agents/tracks/mini');
		}
	}
	

	public function track_search()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/track_search';
		$data['right_side'] = 'agents/right_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function track_branch()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/track_branch';
		$data['right_side'] = 'agents/right_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function track_search_result()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/track_search_result';
		$data['right_side'] = 'agents/right_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	
	public function track_search_branch_result()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/tracks/track_search_result_branch';
		$data['right_side'] = 'agents/right_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	/*  ALL ABOUT TRACK  ENDING*/
	
	
	//ALL ABOUT customers
	
	public function customers()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/display';
		$data['right_side'] = 'agents/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	public function customers_insert()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/insert';
		$data['right_side'] = 'agents/customers/insert_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function customers_inserting()
	
	{	
	$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/inserting';
		$data['right_side'] = 'agents/customers/insert_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function customers_edit()
	{	
		$this->load->view('login_check');
		$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/edit';
		$data['right_side'] = 'agents/customers/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function customers_editing()
	{	
		$this->load->view('login_check');
		$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/editing';
		$data['right_side'] = 'agents/customers/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function customers_history()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/customers/history';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function customers_detail()
	{	
		$this->load->view('login_check');
		$this->load->view('header');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/customers/detail';
		$data['right_side'] = 'agents/customers/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	/*public function customers_deleting()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		//$this->load->helper('form');
		$this->load->view('header');
		$data['content'] = 'agents/customers/deleting';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	*/
	public function customers_import()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/customers/import';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function customers_importing()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/customers/importing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	//ALL ABOUT customers ENDING
	
	
	
	//ALL ABOUT boxes
		
	public function boxes()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/display';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	
	public function boxes_package_list_create()
	{	
		//$this->load->view('header');
		//$this->load->view('top_menu');
		//$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
			$this->load->view('agents/boxes/boxes_package_list_create');
		}
		//redirect('admin/boxes');
	}


	
	public function boxes_history()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/history';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_create()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/create';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function boxes_creating()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/creating';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_edit()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/boxes/edit';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function boxes_editing()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/boxes/editing';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	
	public function boxes_detail()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/detail';
		$data['right_side'] = 'agents/boxes/box_detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_deleting()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('header');
		$data['content'] = 'agents/boxes/deleting';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	
	public function boxes_fill()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/fill';
		$data['right_side'] = 'agents/boxes/box_detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_filling()
	{	
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/filling';
		}
		//else $data['content']='home_content';
		$this->load->view('content_empty',$data);
		$this->load->view('footer_empty');
	}
	
	
	public function boxes_removing()
	{	
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/removing';
		}
		//else $data['content']='home_content';
		$this->load->view('content_empty',$data);
		$this->load->view('footer_empty');
	}
	
	public function boxes_changing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/changing';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_close()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/close';
		$data['right_side'] = 'agents/boxes/box_detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function boxes_preview()
	{	
	
		$this->load->view('header_empty');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
			$this->load->view('agents/boxes/preview');
		}
		$this->load->view('footer_empty');
	}
	
	
	public function boxes_relative()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/relative';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function boxes_relative_display()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/relative_display';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function combine_display()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/combine_display';
		$data['right_side'] = 'agents/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_combine()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/combine';
		$data['right_side'] = 'agents/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function boxes_combining()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/combining';
		$data['right_side'] = 'agents/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function combine_preview()
	{	
		//$this->load->view('header_empty');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('agents/boxes/combine_preview');
		//$this->load->view('content',$data);
		}
	}
	
	
	public function combine_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/combine_delete';
		$data['right_side'] = 'agents/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
	
	public function boxes_outside()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/outside';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function boxes_search()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/search';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_searching()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/boxes/searching';
		$data['right_side'] = 'agents/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	//ALL ABOUT boxes ENDING






	//ALL ABOUT CONTAINER
		
	public function container()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/display';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	

	public function container_insert()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/create';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_inserting()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/creating';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_edit()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/edit';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_editing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/editing';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_detail()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/detail';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_outside()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/outside';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/deleting';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function container_log_insert()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/log';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_log_inserting()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/loging';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_item_detail()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_detail';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_insert()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_insert';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_inserting()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_inserting';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_put()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/put';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_putting()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/putting';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_item_out()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/out';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_item_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_delete';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_print()
	{	
		$this->load->view('header_empty');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$this->load->view('agents/container/print');
		}
		$this->load->view('footer_empty');
	}

	public function container_cp72()
	{	
		if ($this->session->userdata('agent_login'))
		{
			$this->load->view('agents/container/cp72');
			//$this->load->view('content',$data);
		}

	}

	
	public function container_item_edit()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_edit';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_editing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_editing';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function container_item_price()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_price';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_item_pricing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/item_pricing';
		$data['right_side'] = 'agents/container/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}




		public function report()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/settings/report';
		$data['right_side'] = 'agents/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}



	public function container_fill()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/fill';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function container_filling()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('agent_login'))
		{
		$data['content'] = 'agents/container/filling';
		$data['right_side'] = 'agents/container/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	
	//ALL ABOUT CONTAINER ENDING
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */