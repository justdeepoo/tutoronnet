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
			$this->db->insert($data['table'], $data['data']);
			return $this->db->insert_id();
		}
	

		public function addEvent($event_type, $data){

			$this->load->library('notification');

			$event = [
				'user_id'=>$data['user_id'],
				'event'=>$event_type,
				'event_data'=>json_encode($data),
				'event_trigger_at'=>date('Y-m-d h:i:s')
			];


			$data=[
	    		'table'=>'events',
	    		'data'=>$event,
	    	];

	     	if($this->save($data))
	     		return ['error_status'=>false, 'message'=>'Event added successfully'];
	     	else
	     		return ['error_status'=>true, 'message'=>'Technical issue #3'];
		}
		public function upd($p)                 
		{
	        
			$qry = $this->db->update($p['table'], $p['data'], $p['where']);
			
			if($this->db->affected_rows() > 0)
			{ 
				return true;
			}
			else
			{
				return false;
			}
		}
	}
?>

		