<?php	class Index extends Front_Controller 	{		public function __construct()		{			parent::__construct();		}		function index()		{			$this->template_header=NULL;			$this->data['meta_title']='Homework Help Tutor |  Homework Help Online | Accounting Assignment Help | Assignment Help Online';			$this->data['meta_key']='homework help, assignment help, statistics, finance, accounting, math, online tutors';			$this->data['meta_description']='Tutors On Net provides homework help, homework help online, homework helper, accounting help online, assignment help. Submit your assignments & receive solutions';									$path = '../js/ckfinder';			$width = '100%';			$this->editor($path, $width);			$this->form_validation->set_rules('question', 'Page Description', 'trim|required|xss_clean');						$this->data['subjects'] = $this->common->get(['table'=>'subjects','where'=>['is_active'=>1],'select'=>['id','subject']]);						if($this->session->flashdata('error-message'))			{				$this->data['error_message'] =  $this->session->flashdata('error-message');			}						$this->view($this->theme.'/frontend/index', $this->data);		}					}
?>