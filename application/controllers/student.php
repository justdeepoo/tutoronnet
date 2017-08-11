<?php
class Student extends Std 
{
	public function __construct()
	{
		parent::__construct();
		$this->template_footer = $this->theme.'/student/templates/footer';
		$this->template_header = $this->theme.'/student/templates/header';
	}
	public function dashboard()
	{
		$this->data['subjects'] = $this->common->get(['table'=>'subjects','where'=>['is_active'=>1],'select'=>['id','subject']]);

		$w =[];
		$this->load->model('Question_model', 'question');
		$w['order_by'] = ['col'=>'q.created_at', 'order'=>'desc'];
		$w['where'] = ['sq.student_id'=>$this->user_id];
		$questions  = $this->question->getQuestions($w);
		$this->data['questions'] = $questions;

		$this->data['meta_title']="Student Dashboard";
		$this->data['meta_key']="";
		$this->view($this->theme.'/student/dashboard', $this->data);
	}
	
}
?>