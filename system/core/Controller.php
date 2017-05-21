<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
	public function ckeditor()
	{
		$id='description';
		
		return array(
			'id' 	=> 	$id,
			'path'	=>	'js/ckeditor',
			//Optionnal values
			'config' => array(
				'toolbar' => "Full", 	//Using the Full toolbar
				'width'  => "750px",	//Setting a custom width
				'height' => '150px',	//Setting a custom height
			),
			//Replacing styles from the "Styles tool"
			'styles' => array(
			//Creating a new style named "style 1"
			'style 1' => array (
			'name' 		=> 	'Blue Title',
			'element' 	=> 	'h2',
			'styles' => array(
			'color' 			=> 	'Blue',
			'font-weight' 		=> 	'bold'
			)
		),
						
		)
		);
	}
	public function getLocaltimeFromOtherTime($fromDate, $timeZone=NULL)
	{ 
		if(@$_COOKIE['timezoneName']!=null)
			$tz_to =@$_COOKIE['timezoneName'];
		else
			$tz_to =date_default_timezone_get();
		if($timeZone==NULL)
			$fromTimezone = date_default_timezone_get();
		else
			$fromTimezone = $timeZone;
		$time_str=date('Y-m-d H:i:s',strtotime($fromDate));
		$format='Y-m-d H:i:s';
		$dt = new DateTime($time_str, new DateTimezone($fromTimezone));
		$timestamp = $dt->getTimestamp();
		return $dt->setTimezone(new DateTimezone($tz_to))->setTimestamp($timestamp)->format($format);
	}
	public function getUTCFromOtherTime($fromDate)
	{ 
		$tz_to ='UTC';
		if(@$_COOKIE['timezoneName']!=null)
			$fromTimezone = @$_COOKIE['timezoneName'];
		else
			$fromTimezone =date_default_timezone_get();
		
		$time_str=date('Y-m-d H:i:s',strtotime($fromDate));
		$format='Y-m-d H:i:s';
		$dt = new DateTime($time_str, new DateTimezone($fromTimezone));
		$timestamp = $dt->getTimestamp();
		return $dt->setTimezone(new DateTimezone($tz_to))->setTimestamp($timestamp)->format($format);
	}
	public function getTimeZone()
	{
		 if(@$_COOKIE['timezoneName']!=null)
			return @$_COOKIE['timezoneName'];
		else
			return date_default_timezone_get();
	}
	public function changeClassroomStatus($meeting_id)
	{
		$data=array(
			'class_status'=>2,
			'start_time'=>date('Y-m-d H:i:s')
		);
		return $this->db->where('meeting_id',$meeting_id)
		->update('TP_classroom',$data);
	}
	public function insertJoinUserTable($meeting_id, $userType)
	{
		$data=array(
			'meeting_id'=>$meeting_id,
			'user_name'=>$this->session->userdata('name'),
			'user_type'=>$userType,
		);
		return $this->db->insert('TP_join_users',$data);
	}
	public function getRecordingId()
	{
		$recording_id=$this->db->select('recording_id')->where('id',$this->session->userdata('user_id'))
		->get('TP_users')->row()->recording_id;
		
		$user_id=$this->session->userdata('user_id');
		$query="update TP_users set recording_id=recording_id+1 where id=$user_id";
		$this->db->query($query);
		
		return $recording_id;
	}
	public function insertWbRecordTrack($meeting_id, $recording_id)
	{
		$data=array(
			'meeting_id'=>$meeting_id,
			'creator_id'=>$this->session->userdata('user_id'),
			'start_time'=>round(microtime(true) * 1000),
			'recording_id'=>$recording_id,
		);
		return $this->db->insert('TP_class_recording',$data);
	}
	public function getStartEndTime($creator_id, $recording_id)
	{
		return $this->db->select('start_time, end_time')
		->where('creator_id', $creator_id)
		->where('recording_id', $recording_id)
		->get('TP_class_recording')->row();
	}
	public function updateEndTimeToRecordingTable($meeting_id)
	{
		return $this->db->set('end_time', round(microtime(true) * 1000))
		->where('meeting_id', $meeting_id)
		->update('TP_class_recording'); 
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */