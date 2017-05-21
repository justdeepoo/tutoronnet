<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function check3Months($last_login)
	{
		$date=strtotime(date('Y-m-d H:i:s'));
		if($last_login='' || $last_login==NUll)
		{
			return 0;
		}
		else
		{
			$old_password=strtotime($last_login. '+ 3 months');
			if($old_password > $date)
			{
				return 1;
			}
			else
				return 0;
		}
	}
	public function validate()
	{  
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$query=$this->db->select('u.*')
		->where('u.username', trim($username))
		->where('u.password', trim($password))
		->get('wp_users as u');
		
		if($query->num_rows())
		{
			$query=$query->row();
			if($query->isActive==0)
				return 2;
			$options=NULL;
			
			
			$newdata = array(
				'loggedAdmin_in' => TRUE,
				'name'=>$username,	
				'user_type'=>$query->user_type,
				'user_id'=>$query->id,
				'userTypeId'=>$query->user_type,	
				'email'=>$query->email,	
			);	
			$this->session->set_userdata($newdata); // create session
			//update last login date
			$this->db->where('id', $query->id)
			->set('last_login', $this->current_date)
			->update('wp_users');
			
			// $status=$this->check3Months($query->last_change_pass);
			// if($status==0)
				// $this->session->set_userdata('last_change_pass',false);
			// else
				// $this->session->set_userdata('last_change_pass',true);

			
			//check remember tag
			if($this->input->post('remember_me'))
			{
				$cookie = array(
					'name'   => 'cooky_username',
					'value'  =>  $this->input->post('username'),
					'expire' => (86400 * 30)
				);
				$this->input->set_cookie($cookie);
				
				$cookie = array(
					'name'   => 'cooky_password',
					'value'  =>  $this->input->post('password'),
					'expire' => (86400 * 30)
				);
				$this->input->set_cookie($cookie);
			}
			else{
				delete_cookie("cooky_username");
				delete_cookie("cooky_password");
			}
			
			return 1;
		}
		else
			return 0;
	}
	public function passchange()
	{
		$data=array(
			'password'=>md5($this->input->post('password')),
			'last_change_pass'=>date('Y-m-d H:i:s')
		);
		$this->db->where('id', $this->user_id);
		$this->db->update('WM_users',$data);
		
	}
	
}