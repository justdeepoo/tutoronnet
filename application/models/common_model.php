<?php 
	class Common_model extends CI_Model{
		function __costruct()
		{
			Parent::__construct();
			$this->load->database();
		}
		function get($data){
			if(isset($data['select']))
			{
				$this->db->select($data['select']);
			}
			if(isset($data['where']))
			{
				$this->db->where($data['where']);
			}
			return $this->db->get($data['table']);
			
		}
		function save($data){
			$this->db->insert($data['table'],$data['data']);
			return $this->db->insert_id();
		}
	}
?>

		