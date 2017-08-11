<?php

	class Question_model extends CI_Model{
		function __costruct()
		{
			Parent::__construct();
			$this->load->database();
		}
		public function getQuestions($p){

			if(isset($p['where']))
			{
				$this->db->where($p['where']);
			}
			if(isset($p['order_by']))
			{
				$this->db->order_by($p['order_by']['col'], $p['order_by']['order']);	
			}
			$this->db->select('q.question, q.doc_name, q.created_at,  sq.status');
			$this->db->join('student_questions as sq', 'sq.question_id=q.id');
			return $this->db->get('questions as q');
		}
	}
?>

		