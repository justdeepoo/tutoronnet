<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller
{
	public $template='';
	public $data=array();
	public $current_date='';
	public $ajax=true;
	public $CSS_URl='';
	public $JS_URl='';
	public $MEDIA_URl='';
	protected $template_header='';
	protected $template_footer='';
	public $theme='gyan';
	public $root_path="";
	public $user_id = false;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('security');
		$this->load->library('form_validation');
		
		$this->data['CI']=$this;
		
		$this->data['ajax']=$this->ajax;
		$this->current_date=date('Y-m-d H:i:s');

		if($this->session->userdata('user_login'))
			$this->user_id=$this->session->userdata('user_id');
		
		$this->root_path = ROOT_PATH;
	}
	/*
		This function simply calls $this->load->view()
	*/
	function partial($view, $vars = array(), $string=false)
	{
		if($string)
		{
			return $this->load->view($view, $vars, true);
		}
		else
		{
			$this->load->view($view, $vars);
		}
	}
	function editor($path,$width) {
		//Loading Library For Ckeditor
		$this->load->library('ckeditor');
		$this->load->library('ckFinder');
		//configure base path of ckeditor folder 
		$this->ckeditor->basePath = base_url().'js/ckeditor/';
		$this->ckeditor-> config['toolbar'] = 'Full';
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor-> config['width'] = $width;
		//configure ckfinder with ckeditor config 
		$this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
	}
	function view($view, $vars = array(), $login=false)
	{

		if(!isset($vars['meta_title']))
			$vars['meta_title']='';
		if(!isset($vars['meta_key']))
			$vars['meta_key']='';
		if(!isset($vars['meta_description']))
			$vars['meta_description']='';
		
		if($this->template_header!=NULL)
			$this->load->view($this->template_header, $vars);
		
		$this->load->view($view, $vars);
		if($this->template_footer!=NULL)
			$this->load->view($this->template_footer);
		
	}
}//end Base_Controller

class Front_Controller extends Base_Controller 
{
	private $recipient_email='';
	function __construct()
	{
		parent::__construct();
		$this->load->model('common_model','common');
		$this->template_header=$this->theme.'/frontend/template/header';
		$this->template_footer=$this->theme.'/frontend/template/footer';
		
		$this->CSS_URl=$this->root_path.'skin/'.$this->theme.'/css/';
		$this->JS_URl=$this->root_path.'skin/'.$this->theme.'/js/';
		$this->MEDIA_URl=$this->root_path.'skin/'.$this->theme.'/images/';
	}
}
class Auth_Controller extends Base_Controller 
{
	private $recipient_email='';
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		if($this->session->userdata('loggedAdmin_in')==TRUE)
			redirect(base_url());
	}
}
class Admin_Controller extends Base_Controller 
{
	public $template=false;
	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loggedAdmin_in')!=TRUE)
			redirect(base_url().'login/');
		
		// if($this->session->userdata('last_change_pass')==false)
			// redirect(base_url().'secure/change_password');
		
		$this->load->model('order_model');
		
		$this->CSS_URl=base_url().'assets/';
		$this->JS_URl=base_url().'assets/';
		$this->MEDIA_URl=base_url().'assets/';
		$this->data['order_page'] = false;
	}
	public function getAdminId(){
		return $this->user_id;
	}
}

class Priviledge_Controller extends Base_Controller 
{
	public $user_id='';
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('user_login')!=TRUE)
			redirect(base_url().'secure/signup');
		$this->load->model('login_model');
		
		$this->user_id=$this->session->userdata('user_id');
		
	}
}
/**
*  
*/
class Std extends Base_Controller
{
	
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('user_login')!=TRUE)
			redirect(base_url().'secure/login');
		$this->user_id=$this->session->userdata('user_id');
		$this->load->model('common_model','common');
		
		
		$this->CSS_URl=$this->root_path.'skin/'.$this->theme.'/css/';
		$this->JS_URl=$this->root_path.'skin/'.$this->theme.'/js/';
		$this->MEDIA_URl=$this->root_path.'skin/'.$this->theme.'/images/';
	}
}




