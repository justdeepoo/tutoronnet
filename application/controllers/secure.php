<?php
class Secure extends Front_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	function post_question()
	{
		$this->form_validation->set_rules('question', "Question", 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error-message','Please type your question.');
			redirect(base_url());
		}
		
		$question = trim(strip_tags($this->input->post('question')));
		
		$token = md5(time().$this->input->ip_address());
		$data = [
			'token'=>$token,
			'question'=>$question,
			'created_at'=>$this->current_date,
			'ip_address'=>$this->input->ip_address()
		];
		if($this->common->set(['table'=>'questions','data'=>$data]))
		{
			redirect(base_url().'secure/signup?token='.$token);
		}
		else{
			
		}
	}
	public function signup(){
		
		$this->template_footer = $this->theme.'/frontend/secure/footer';
		$this->form_validation->set_rules('firstname', $this->lang->line('firstname'), 'required|xss_clean|max_length[25]');
		$this->form_validation->set_rules('lastname', $this->lang->line('lastname'), 'required|xss_clean|max_length[25]');
		$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|xss_clean|is_unique[users.email]|max_length[50]|valid_email');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required|xss_clean|max_length[25]');
		//$this->form_validation->set_rules('dob', $this->lang->line('dob'), 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			if(isset($_GET['token']))
			{
				$token = trim($_GET['token']);
				$this->data['token'] = $token;
			}
			
			$this->data['signup']=true;
			if($this->ajax && $this->input->post('submitted')){
				
				$fields=array(
					'firstname'=>true,
					'lastname'=>true,
					'email'=>true,
					'username'=>true,
					'password'=>true,
					'conf_password'=>true,
					'dob'=>true,
				);
				foreach($fields as $field=>$val){
					if(form_error($field)){
						$fields[$field]=form_error($field);
					}
				}
				die(json_encode(array('result'=>false, 'fields'=>$fields, 'validation_error'=>true)));
				return ;
			}
			$this->data['meta_title']="User Signup";
			$this->data['meta_key']="";
			$this->view($this->theme.'/frontend/secure/signup', $this->data);
		}
		else
		{
			$data=array(
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'mobile'=>$this->input->post('mobile'),
				'user_type'=>$this->input->post('user_type'),
				'is_active'=>1,
				'created_at'=>$this->current_date
			);
			
			$user_id=$this->common->save(['table'=>'users', 'data'=>$data]);
			if($user_id)
			{
				$save=array(
					'user_id'=>$user_id,
					'firstname'=>$this->input->post('firstname'),
					'lastname'=>$this->input->post('lastname'),
					'gender'=>$this->input->post('gender'),
					'dob'=>date('Y-m-d',strtotime($this->input->post('dob'))),
					'updated_at'=>$this->current_date
				);
				$this->common_model->table_name='user_profiles';
				$user_profile_id=$this->common_model->save($save);
				
				$key=md5(time().$user_id);
				$data=array(
					'key'=>$key,
					'user_id'=>$user_id,
					'created_date'=>$this->current_date,
					'use_for'=>'activate account',
				);
				$this->common_model->table_name='activation_keys';
				if($this->common_model->save($data))
				{	
					$this->recipient_email=trim($this->input->post('email'));
					$msg="Hi, </br>Please <a href='".base_url()."secure/activate_account/$key' target='_blank'> click here </a> to activate your account.";
					$this->send_email('Activate Account', $msg);
					$message=$this->lang->line('user-account-created');
				}
			}
			if($this->ajax){
				die(json_encode(array('result'=>true, 'message'=>$message, 'fields'=>'', 'validation_error'=>false)));
				return ;
			}
			$this->session->set_flashdata('message', $message);
			redirect(base_url().'secure/user/signup/');
		}
	}
	
	public function admin_login()
	{
		if($this->session->userdata('admin_logged_in'))
			redirect(base_url().'admin/');
		$this->form_validation->set_rules('username', $this->lang->line('user'), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$this->data=array(
				'meta_title'=>'Admin Login',
				'meta_key'=>'',
			);
			$this->view('secure/admin/login', $this->data);
		}
		else
		{
			$data=array(
				'username'=>$this->input->post('username'),
				'password'=>md5($this->input->post('password')),
			);
			$this->index_model->table_name='admin_users';
			if($this->index_model->login($data, 1))
				redirect(base_url().'admin');
			else{
				$this->session->set_flashdata('error', 'Login details is incorrect.');
				redirect(base_url().'secure/admin/login/');
			}
		}
	}
	public function forgot_password()
	{
		$this->template_footer = $this->theme.'/frontend/secure/footer';
		$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|xss_clean|valid_email');
		if ($this->form_validation->run()== FALSE)
		{
			
			if($this->ajax && $this->input->post('submitted')){
				$fields=array(
					'email'=>true,
				);
				foreach($fields as $field=>$val){
					if(form_error($field)){
						$fields[$field]=form_error($field);
					}
				}
				die(json_encode(array('result'=>false, 'fields'=>$fields, 'validation_error'=>true)));
				return ;
			}
			$this->data['forget']=true;
			if($this->session->flashdata('admin'))
				$this->data['admin']=true;
			$this->view($this->theme.'/frontend/secure/forgot', $this->data);
		}
		else
		{
			$this->common_model->table_name='users';
			$where=array(
				'email'=>$this->input->post('email'),
				'is_active'=>1
			);
			$select=array('id');
			$result=$this->common_model->getModelData($select, $where);
			
			if(!$result)
			{
				if($this->ajax && $this->input->post('submitted')){
					$message="There is some technical issue. Please contact to our support team.";
					die(json_encode(array('result'=>false, 'message'=>$message, 'fields'=>'', 'validation_error'=>false)));
					return ;
				}
				redirect(base_url().'secure/forgot-password');
			}	
			if($result->num_rows())
			{
				$user=$result->row();
				$key=md5(time().$user->id);
				$data=array(
					'key'=>$key,
					'user_id'=>$user->id,
					'created_date'=>$this->current_date,
					'use_for'=>'reset password',
				);
				$this->common_model->table_name='activation_keys';
				if($this->common_model->save($data))
				{
					$this->recipient_email=trim($this->input->post('email'));
					$msg="Hi, </br>Please <a href='".base_url()."secure/reset_password/$key' target='_blank'> click here </a> for your password reset.";
					$this->send_email('Password Reset link', $msg);
					$message=$this->lang->line('send-forgot-password-link');
				}
				else
					$message='There is some technical issue. Please contact to our support team.';
				
			}
			else{
				$message=$this->lang->line('not-found-email');
			}
			
			
			if($this->ajax && $this->input->post('submitted')){
				die(json_encode(array('result'=>false, 'message'=>$message, 'fields'=>'', 'validation_error'=>false)));
				return ;
			}
			$this->session->set_flashdata('message', $message);
			redirect(base_url().'secure/forgot-password/');
		}
	}
	public function send_email($subject, $msg){
		
		$config = Array(       
            'mailtype'  => 'html',
        );
		
		$this->load->library('email', $config);
		$this->email->from('info@youlogix.com', 'Careerlife360');
		$this->email->to($this->recipient_email);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');

		$this->email->subject($subject);
		$this->email->message($msg);
		$this->email->send();
		//echo $this->email->print_debugger();
	}
	public function logout(){
		$this->session->sess_destroy();
		if($this->session->userdata('admin_logged_in'))
			redirect(base_url().'secure/admin/login/');
		else
			redirect(base_url());
	}
	public function activate_account($key=null){
		
		if($key!=null)
		{
			$where=array(
				'key'=>$key,
				'is_active'=>1,
				'use_for'=>'activate account'
			);
			$select=array(
				'user_id',
				'id'
			);
			$this->common_model->table_name='activation_keys';
			$response=$this->common_model->getModelData($select, $where);
			if(!$response){
				$data['found']=false;
				$data['message']= $this->lang->line('db_error');
			}
			else{
				if($response->num_rows() > 0){
					$row=$response->row();
					$data['found']=true;
					$data['key']=$key;
					$data['message']=$this->lang->line('activated-link');
					//detactivate $key
					$user_id=$row->user_id;
					$save=array(
						'id'=>$row->id,
						'is_active'=>0,
					);
					$response=$this->common_model->save($save);
					
					//Now user we will activate user
					$this->common_model->table_name='users';
					$save=array(
						'id'=>$row->user_id,
						'ac_varified'=>1,
					);
					$response=$this->common_model->save($save);
					
					
					
					// send acknowledge mail - 
					$where=array(
						'id'=>$row->user_id,
					);
					$select=array(
						'email'
					);
					$this->common_model->table_name='users';
					$row=$this->common_model->getModelData($select, $where);
					if($row->num_rows() > 0)
					{
						$user=$row->row();
						$this->recipient_email=trim($user->email);
						$msg=$this->lang->line('activated-link');
						$this->send_email($this->lang->line('account-activate-subject'), $msg);
					}
					
					// add Notification for test
					$this->common_model->addNotification('start test', $user_id);
				}
				else{
					$data['message']=$this->lang->line('wrong-activation-link');
					$data['found']=false;
				}
				$data['meta_title']="Activate Account";
				$data['meta_key']="";
				$this->view('secure/activate-account', $data);
			}
		}
		else
			show_404();
	}
	public function reset_password($key=null){
		if($key!=null)
		{
			$where=array(
				'key'=>$key,
				'is_active'=>1,
				'use_for'=>'reset password'
			);
			$select=array(
				'user_id'
			);
			
			$this->common_model->table_name='activation_keys';
			$response=$this->common_model->getModelData($select, $where);
			if(!$response){
				$data['found']=false;
				$data['message']= $this->lang->line('db_error');
			}
			else{
				if($response->num_rows() > 0){
					$data['found']=true;
					$data['key']=$key;
				}
				else{
					$data['message']=$this->lang->line('wrong-reset-link');
					$data['found']=false;
				}
				$this->form_validation->set_rules('password', $this->lang->line('password'), 'required|xss_clean');
				$this->form_validation->set_rules('conf_password', $this->lang->line('conf_password'), 'required|xss_clean|matches[password]');
				
				if ($this->form_validation->run()== FALSE)
				{
					$data['meta_title']='';
					$data['meta_key']='';
					$data['meta_description']='';
					$this->view('secure/admin/reset-password', $data);
					
				}
				else{
					$res=$response->row();
					$save=array(
						'id'=>$res->user_id,
						'password'=>md5($this->input->post('password')),
					);
					$this->common_model->table_name='users';
					$response=$this->common_model->save($save);
					if($response){
						$save=array(
							'key'=>$key,
							'is_active'=>0,
						);
						$this->common_model->table_name='activation_keys';
						$response=$this->common_model->save($save);
						$this->session->set_flashdata('error', $this->lang->line('reset-password-confirm'));
					}
					redirect(base_url().'secure/login/');
				}
			}
		}
		else
			show_404();
	}
	
	public function login(){
		$this->template_footer = $this->theme.'/frontend/secure/footer';
		if($this->session->userdata('user_logged_in'))
			redirect(base_url().'personal_center/');
		$this->form_validation->set_rules('username', $this->lang->line('user'), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$this->data['login']=true;
			if($this->ajax && $this->input->post('submitted')){
				$fields=array(
					'username'=>true,
					'password'=>true,
				);
				foreach($fields as $field=>$val){
					if(form_error($field)){
						$fields[$field]=form_error($field);
					}
				}
				die(json_encode(array('result'=>false, 'fields'=>$fields, 'validation_error'=>true)));
				return ;
			}
			$data['meta_title']="User Login";
			$data['meta_key']="";
			$this->view($this->theme.'/frontend/secure/login', $this->data);
		}
		else
		{
			
			$data=array(
				'username'=>$this->input->post('username'),
				'password'=>md5($this->input->post('password')),
			);
			$this->index_model->table_name='users';
			$login_status=$this->index_model->login($data, 2);
			if($login_status==1)
			{
				if($this->ajax){
					die(json_encode(array('result'=>true, 'message'=>'sucessfully login', 'fields'=>'', 'validation_error'=>false)));
					return ;
				}
				
				redirect(base_url().'personal_center/');
			}
			else
			if($login_status==2)
				$error=$this->lang->line('account-not-varified');
			else
				$error=$this->lang->line('incorrect-login');
			
			if($this->ajax){
				die(json_encode(array('result'=>false, 'message'=>$error, 'fields'=>'', 'validation_error'=>false)));
				return ;
			}
			
			$this->session->set_flashdata('error', $error);
			redirect(base_url().'secure/login');
		
		}
	}
}
?>