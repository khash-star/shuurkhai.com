<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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

		$data['content'] = 'admin/home_content';
		$data['right_side'] = 'admin/right_side';

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
	
	///////////////////////////////////// ALL ABOUT ORDERS ///////////////////////////////////////////
	public function orders()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/display_search';
		$data['right_side'] = 'admin/orders/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function orders_detail()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/detail';
		$data['right_side'] = 'admin/orders/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/changing';
		$data['right_side'] = 'admin/orders/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/delete';
		$data['right_side'] = 'admin/orders/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/deleting';
		$data['right_side'] = 'admin/orders/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function preview()
	{
		//$this->load->view('login_check');
		//$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('preview');
		//$this->load->view('content',$data);
		}
	}
	
	public function create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/create';
		$data['right_side'] = 'admin/orders/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/orders/creating';
		$data['right_side'] = 'admin/orders/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function edit()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->library('table');
		$this->load->view('header');
		$data['content'] = 'admin/orders/edit';
		
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
		public function editing()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/orders/editing';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	
	
	
	
	///////////////////////////////////// ALL ABOUT ORDERS ENDING////////////////////////////////////
	
	
	/*  ALL ABOUT TRACK */
		public function tracks()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/display_search';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	/*public function tracks_display()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/tracks/display';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	public function tracks_display_search()
	{
		$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header_empty');
		$data['content'] = 'admin/tracks/display_search';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/insert';
		$data['right_side'] = 'admin/tracks/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/checking';
		$data['right_side'] = 'admin/tracks/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/checking2';
		$data['right_side'] = 'admin/tracks/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/checking3';
		$data['right_side'] = 'admin/tracks/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/checking4';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
		public function tracks_check()
	{
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/display_search';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content_empty',$data);
		$this->load->view('footer_empty');

	}
	
	public function tracks_adding()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/adding';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	public function tracks_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/edit';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function tracks_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/editing';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function tracks_detail()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/detail';
		$data['right_side'] = 'admin/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
		public function tracks_changing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/changing';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function tracks_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/deleting';
		$data['right_side'] = 'admin/tracks/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	public function tracks_preview()
	{
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('preview');
		}

	}

	public function tracks_proxy_delete()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/proxy_delete';
		$data['right_side'] = 'admin/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}


		public function tracks_modify()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/modify';
		$data['right_side'] = 'admin/tracks/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}

		public function tracks_modifying()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/modifying';
		$data['right_side'] = 'admin/tracks/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/display';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	public function customers_all()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/customers_all';
		$data['right_side'] = 'admin/customers/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/insert';
		$data['right_side'] = 'admin/customers/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/inserting';
		$data['right_side'] = 'admin/customers/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

		
	}
	
	public function customers_edit()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/edit';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function customers_editing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/editing';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function customers_history()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/customers/history';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function customers_detail()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/edit';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_deleting()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		//$this->load->helper('form');
		$this->load->view('header');
		$data['content'] = 'admin/customers/deleting';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function customers_import()
	{	
	
	$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/import';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function customers_importing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/importing';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function customers_check()
	{
		$this->load->view('admin/customers/check');
	}

		public function customers_check2()
	{
		$this->load->view('admin/customers/check2');
	}
	
	
	
		//ALL ABOUT customers ENDING
		
		//ALL ABOUT proxy
	
	public function customers_proxy()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_add()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_add';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_adding()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_adding';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}

	
	public function customers_proxy_edit()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_edit';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_editing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_editing';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_delete';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_add_excel()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_import';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function customers_proxy_adding_excel()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/customers/proxy_importing';
		$data['right_side'] = 'admin/customers/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}


	public function proxy()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function proxy_add()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy_add';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function proxy_adding()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy_adding';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function proxy_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy_delete';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function proxy_add_excel()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy_import';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	public function proxy_adding_excel()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/proxy_importing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	
	
	
	//ALL ABOUT proxy ENDING
	
	
	
	//ALL ABOUT boxes
		
	public function boxes()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/display';
		$data['right_side'] = 'admin/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function boxes_excel_refresh()
	{	
		//$this->load->view('header');
		//$this->load->view('top_menu');
		//$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('admin/boxes/excel_refresh');
		}
		//redirect('admin/boxes');
	}


	public function boxes_search()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/search';
		$data['right_side'] = 'admin/boxes/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/searching';
		$data['right_side'] = 'admin/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function boxes_history()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/history';
		$data['right_side'] = 'admin/boxes/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/create';
		$data['right_side'] = 'admin/boxes/display_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/creating';
		$data['right_side'] = 'admin/boxes/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_edit()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/boxes/edit';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	public function boxes_editing()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/boxes/editing';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	
	public function boxes_detail()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/detail';
		$data['right_side'] = 'admin/boxes/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function boxes_deleting()
	{	$this->load->view('login_check');
		$this->load->view('top_menu');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/boxes/deleting';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	
	public function boxes_fill()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/fill';
		$data['right_side'] = 'admin/boxes/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/filling';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/changing';
		$data['right_side'] = 'admin/boxes/detail_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/close';
		$data['right_side'] = 'admin/boxes/box_detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		
	public function boxes_preview()
	{	
	
		$this->load->view('header_empty');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
			$this->load->view('admin/boxes/preview');
		}
		$this->load->view('footer_empty');
	}
	
	
	//ALL ABOUT boxes ENDING
	
	
	//COMBINE RELATED
	
	public function combine_display()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/combine_display';
		$data['right_side'] = 'admin/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function combine_preview()
	{	
		//$this->load->view('header_empty');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('admin/boxes/combine_preview');
		//$this->load->view('content',$data);
		}
	}
	
	public function combine_changing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/combine_changing';
		$data['right_side'] = 'admin/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function combine_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/boxes/combine_delete';
		$data['right_side'] = 'admin/boxes/combine_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
	
	//COMBINE RELATED ENDING
	
	
	//SETTING RELATED 
		public function settings()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/home';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function settings_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function settings_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function logs()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/logs';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function logs_clear()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{
		$this->load->view('header');
		$data['content'] = 'admin/settings/logs_clear';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
		public function events()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function event_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function event_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function event_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events_deleting';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
		public function event_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events_create';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function event_creating()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/events_creating';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
		public function page2_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page2_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page2_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page2_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page3_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page3_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page3_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page3_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page4_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page4_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page4_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page4_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function page5_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page5_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page5_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page5_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page6_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page6_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page6_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page6_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page7_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page7_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function page7_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/page7_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
	public function upload()
	{
		//$this->load->view('header');
		//$this->load->view('top_menu');
		//$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$this->load->view('upload');
		}
		//else $data['content']='home_content';
		//$this->load->view('content',$data);
		//$this->load->view('footer');
	}
	
	
		public function db_backup()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{$this->load->view('header');
		$data['content'] = 'admin/settings/db_backup';
		$this->load->view('content',$data);
		$this->load->view('footer');
		}
	}
	
	//SETTINGS RELATED ENDING
	
	
	//NEWS RELATED 
	
	public function news()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function news_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news_create';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function news_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news_creating';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function news_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news_deleting';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function news_edit()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news_edit';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function news_editing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/news/news_editing';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
	//NEWS RELATED ENDING





	//ALERT RELATED 
	
	public function alerts()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/alert/alert';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function alert_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/alert/alert_create';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function alert_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/alert/alert_creating';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function alert_delete()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/alert/alert_delete';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	//ALERT  RELATED ENDING



	//AGENTS RELATED
	public function agents()
	{	$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/display';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function agents_insert()
	{		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/insert';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function agents_inserting()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/inserting';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function agents_edit()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/edit';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}
	public function agents_editing()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/editing';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}
	public function agents_history()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/history';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}
	public function agents_detail()
	{		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{$this->load->helper('form');
		$this->load->view('header');
		$data['content'] = 'admin/agents/detail';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	}
	
	public function agents_delete()
	{	
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/agents/delete';
		$data['right_side'] = 'admin/agents/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function agents_check()
	{		
		$this->load->view('admin/agents/check');
	}
	//AGENTS RELATED ENDING
	


//DELIVER RELATED
public function deliver()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/home';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


public function deliver_tel()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/deliver_tel';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function deliver_select()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/deliver_select';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function deliver_container()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/home_container';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function deliver_select_container()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/deliver_select_container';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	public function delivering()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivering';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


		public function delivering_container()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivering_container';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}



	public function reverse()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/reverse';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function reversing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/reversing';
		$data['right_side'] = 'admin/deliver/deliver_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}



	public function delivered()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered';
		$data['right_side'] = 'admin/deliver/delivered_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
		public function delivered_report()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered_report';
		$data['right_side'] = 'admin/deliver/delivered_report_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function delivered_report2()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered_report2';
		$data['right_side'] = 'admin/deliver/delivered_report2_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function delivered_report3()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered_report3';
		$data['right_side'] = 'admin/deliver/delivered_report3_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function delivered_report4()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered_report4';
		$data['right_side'] = 'admin/deliver/delivered_report4_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function delivered_report5()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/report5';
		$data['right_side'] = 'admin/deliver/report5_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	
	
	public function delivered_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/delivered_history';
		$data['right_side'] = 'admin/deliver/delivered_history_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function bill()
	{		
		$this->load->view('header_empty');
		$this->load->view('login_check');
		//if ($this->session->userdata('admin_login'))
		//{
		$this->load->view('admin/deliver/bill');
		//}
		$this->load->view('footer_empty');
	}
//DELIVER RELATED ENDING


// later related	
public function later_proceed()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_proceed';
		$data['right_side'] = 'admin/deliver/later_proceed_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function later_proceedig()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_proceedig';
		$data['right_side'] = 'admin/deliver/later_proceed_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function later_pay()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_pay';
		$data['right_side'] = 'admin/deliver/later_pay_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function later_paid()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_paid';
		$data['right_side'] = 'admin/deliver/later_pay_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function later_transaction()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_transaction';
		$data['right_side'] = 'admin/deliver/later_transaction_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}



public function later_check()
	{
		$this->load->view('admin/deliver/later_check');
	}

public function later_report()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/later_report';
		$data['right_side'] = 'admin/deliver/later_transaction_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	//LATER RETAED ENDING


//HANDOVER
	public function handover()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/handover';
		$data['right_side'] = 'admin/deliver/handover_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function handover_select()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/handover_select';
		$data['right_side'] = 'admin/deliver/handover_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function handovering()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/handovering';
		$data['right_side'] = 'admin/deliver/handover_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

public function handover_report()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/deliver/handover_report';
		$data['right_side'] = 'admin/deliver/handover_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
public function handover_bill()
	{		
		$this->load->view('header_empty');
		$this->load->view('login_check');
		//if ($this->session->userdata('admin_login'))
		//{
		$this->load->view('admin/deliver/handover_bill');
		//}
		$this->load->view('footer_empty');
	}

//


// ONLINE RELATED
public function online()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/display_search';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function all_later()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/all_later';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	
	/*public function online_display_search()
	{
		$this->load->view('login_check');
		if ($this->session->userdata('login'))
		{$this->load->view('header_empty');
		$data['content'] = 'online/display_search';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
		}
		
	}*/
	
		public function online_delete()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_delete';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function online_later()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_later';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
		public function online_unlater()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_unlater';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function online_create()
	{$this->load->view('header');
		$data['content'] = 'online/online_create';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function online_creating()
	{$this->load->view('header');
		$data['content'] = 'online/online_creating';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function online_renew()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_renew';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function online_renewing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_renewing';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function online_track_renew()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_track_renew';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function online_track_renewing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_track_renewing';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
		public function online_comment()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_comment';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function online_commenting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_commenting';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
		public function online_price()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_price';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	public function online_pricing()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_pricing';
		$data['right_side'] = 'admin/online/detail_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	public function online_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_history';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}

	public function online_pending()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_pending';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function online_pendings()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/online/online_pendings';
		$data['right_side'] = 'admin/online/display_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
//ONLINE RELATED ENDING




	//BARCODE RELATED
	public function barcodes()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/barcode/home';
		$data['right_side'] = 'admin/barcode/side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
public function barcode_insert()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/barcode/insert';
		$data['right_side'] = 'admin/barcode/side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
		public function barcode_inserting()
	{
		
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/barcode/inserting';
		$data['right_side'] = 'admin/barcode/side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');

	}	
	
	public function barcode_elimination()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/barcode/elimination';
		$data['right_side'] = 'admin/barcode/side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');	}	
	
	public function barcode_gen()
	{
		$this->load->view('barcode/barcode_gen');
		//$this->load->view('footer');
	}
	
	//BARCODE RELATED ENDING
	
	
	
	
	//HELP RELATED SECTION
	public function help()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
	
	public function help_reply()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_reply';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_replying()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_replying';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_create';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_creating()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_creating';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	
	public function help_history()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_history';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_read()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_read';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
		
	}	
	
	public function help_deleting()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/help/help_deleting';
		$data['right_side'] = 'admin/help/help_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
	
	//HELP RELATED SECTION ENDING
	
	
	//ENVOICE RELATED SECTION
	
	public function envoice_create()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/envoices/create';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	
	
		public function admin_envoice()
	{
		$this->load->view('header_empty');
		//$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/envoices/admin_envoice';
		//$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer_empty');
	}
	
	
	public function envoices()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/envoices/envoices';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		$this->load->view('content',$data);
		$this->load->view('footer');
	}	
	
	public function envoice()
	{
		$this->load->view('header_empty');
		$this->load->view('login_check');
		$this->load->view('admin/envoices/envoice');
		$this->load->view('footer_empty');
		
	}	
	
	
	
	//ENVOICE RELATED SECTION ENDING
	
	
	
	
	//REPORT
	
	public function report()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/report';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	
	public function warehouse()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/settings/warehouse';
		$data['right_side'] = 'admin/settings/settings_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}
	//REPORT ENDING
	
	
	
	
	//FAQS
		public function faqs()
		{
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
			public function faqs_edit()
		{
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs_edit';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
			public function faqs_editing()
		{
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs_editing';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
			public function faqs_deleting()
		{
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs_deleting';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
			public function faqs_create()
		{
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs_create';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
		public function faqs_creating()
		{
			
			$this->load->view('header');
			$this->load->view('top_menu');
			$this->load->view('login_check');
			if ($this->session->userdata('admin_login'))
			{
			$data['content'] = 'admin/faqs/faqs_creating';
			$data['right_side'] = 'admin/faqs/faqs_side';
			}
			else $data['content']='home_content';
			$this->load->view('content',$data);
			$this->load->view('footer');
		}
			
	public function track_search()
	{
		$this->load->view('header');
		$this->load->view('top_menu');
		$this->load->view('login_check');
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/track_search';
		$data['right_side'] = 'admin/right_side';
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
		if ($this->session->userdata('admin_login'))
		{
		$data['content'] = 'admin/tracks/track_search_result';
		$data['right_side'] = 'admin/right_side';
		}
		else $data['content']='home_content';
		$this->load->view('content',$data);
		$this->load->view('footer');
	}


	
	
	
	//FAQS ENDING
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */