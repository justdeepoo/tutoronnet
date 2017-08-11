<?php
class Secure extends Front_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}
	public function createFolder($path){
		
		$oldmask = umask(0);
		mkdir($path, 0777);
		umask($oldmask);

	}
	function post_question()
	{

		$this->form_validation->set_rules('question', "Question", 'required|xss_clean');
		$this->form_validation->set_rules('subject', "Subject", 'required|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			//die(json_encode(['status'=>201,'response'=>"Please type your question."]));
			$fields=array(
				'question'=>true,
				'subject'=>true,
				'doc'=>true,
			);
			foreach($fields as $field=>$val){
				if(form_error($field)){
					$fields[$field]=form_error($field);
				}
				else{
					unset($fields[$field]);
				}
			}
			die(json_encode(array('status'=>201, 'response'=>$fields, 'validation_error'=>true)));
			return ;
		}

		if($_FILES['doc']['name']=='')
		{

			die(json_encode(array('status'=>201, 'response'=>['doc'=>"Please select document"], 'validation_error'=>true)));
			return ;
		}

		$path = './uploads/docs/'.$this->user_id;
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|pdf|doc|xls|txt';
		$config['max_size']     = 1024*1024*1;
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$config['overwrite'] = false;
		$config['encrypt_name'] = TRUE;
		
		
		$this->load->library('upload', $config);

        if(!is_dir($path))
		{
		  	$this->createFolder($path);
		}

		if (!$this->upload->do_upload('doc'))
        {
            $erro_msg = array('doc' => $this->upload->display_errors());
            die(json_encode(array('status'=>201, 'response'=>$erro_msg, 'validation_error'=>true)));
			
		}
        else
        {
        	$data= $this->upload->data(); 
       	}
       
       	
		$question = trim(strip_tags($this->input->post('question')));
		
		$token = md5(time().$this->input->ip_address());
		
		$data = [
			'token'=>$token,
			'question'=>$question,
			'doc_name'=>$data['file_name'],
			'created_at'=>$this->current_date,
			'ip_address'=>$this->input->ip_address()
		];
		$question_id  = $this->common->save(['table'=>'questions','data'=>$data]);
		
		if($question_id)
		{
			if($this->user_id==false)
			{
				redirect(base_url().'secure/signup?token='.$token);
			}
			else{

				$data = [
					'student_id'=>$this->user_id,
					'question_id'=>$question_id,
					'status'=>1,
				];
				if($this->common->save(['table'=>'student_questions','data'=>$data]))
				{
					$message = "Congratulation! Your question is successfully submitted. Our tutors will notify you as they review your questions.";

					$this->session->set_flashdata('message', $message);


					die(json_encode(['status'=>200,'response'=>"successfully posted"]));
				}
				else{

					die(json_encode(['status'=>201,'response'=>"Sorry question could not be submitted."]));
				}
			}
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
				);
				foreach($fields as $field=>$val){
					if(form_error($field)){
						$fields[$field]=form_error($field);
					}
					else{
						unset($fields[$field]);
					}
				}
				die(json_encode(array('status'=>201, 'response'=>$fields, 'validation_error'=>true)));
				return ;
			}

			$this->data['grades'] = $this->common->get(['table'=>'grades', 'select'=>['id', 'grade_name'], 'where'=>['is_active'=>1]]);

			$this->data['meta_title']="User Signup";
			$this->data['meta_key']="";
			$this->view($this->theme.'/frontend/secure/signup', $this->data);
		}
		else
		{
			$data=array(
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'user_type'=>$this->input->post('user_type'),
				'firstname'=>$this->input->post('firstname'),
				'lastname'=>$this->input->post('lastname'),
				'is_active'=>1,
				'created_at'=>$this->current_date
			);
			
			$user_id=$this->common->save(['table'=>'users', 'data'=>$data]);
			if($user_id)
			{
				if($this->input->post('user_type')==2)
				{
					$save=array(
						'user_id'=>$user_id,
						'grade'=>$this->input->post('grade'),
						'last_updated_at'=>$this->current_date
					);
					
					$student_id=$this->common->save(['table'=>'students', 'data'=>$save]);
					
					$key=md5(time().$user_id);
					$data=array(
						'key'=>$key,
						'user_id'=>$user_id,
						'created_date'=>$this->current_date,
						'use_for'=>'activate account',
					);
					
					if($this->common->save(['table'=>'activation_keys', 'data'=>$data]))
					{	
						$this->recipient_email=trim($this->input->post('email'));
						$msg="Hi, </br>Please <a href='".base_url()."secure/activate_account/$key' target='_blank'> click here </a> to activate your account.";
						$this->send_email('Activate Account', $msg);
						$message=$this->lang->line('user-account-created');
					}


				}
			}
			if($this->ajax){
				die(json_encode(array('status'=>200, 'message'=>$message, 'redirect_url'=>'/students/dashboard/', 'validation_error'=>false)));
				return ;
			}
			$this->session->set_flashdata('message', $message);
			redirect(base_url().'secure/user/signup/');
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
		if($this->session->userdata('user_login'))
			redirect(base_url());
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
		$this->form_validation->set_rules('email', $this->lang->line('email'), 'required|xss_clean');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
		{
			$this->data['login']=true;
			if($this->ajax && $this->input->post('submitted')){
				$fields=array(
					'email'=>true,
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
			
			$w=array(
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'is_active'=>1
			);
			$user = $this->common->get(['table'=>'users', 'where'=>$w, 'select'=>['id', 'user_type']]);


    	
	    	if(!$user->num_rows()){

	    		die(json_encode(['status'=>203,'message'=>'Validation error', 'response'=>"Invalid login details"]));
	    	}

	    	$user = $user->row();
			if($user->user_type==2)
			{
				$response = $this->common->addEvent('STUDENT LOGIN', ['user_id'=>$user->id]);
			}

			//Update last login 
			$d=[
				'last_login_dt'=>$this->current_date,
				'last_login_ip'=>$this->input->ip_address()
			];

			$param = [
				'user_id'=>$user->id,
				//'role_id'=>$user->role_id
			];

			$this->common->upd(['table'=>'users','where'=>['id'=>$user->id],'data'=>$d]);
			

			$this->session->set_userdata('user_login', true);
			$this->session->set_userdata('user_id', $user->id);

			if($this->ajax){
				die(json_encode(array('status'=>200, 'message'=>"login success", "redirect_url"=>'/student/dashboard/')));
				return ;
			}
		}
	}


}
?>