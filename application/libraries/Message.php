<?php


class Message{
	public $cmd;
	public $status;
	public $data;
	public $clientdata;

	function __construct() {
		$this->cmd = "";
		$this->status = "";
		$this->data = "";
		$this->clientdata = "";
	}
}

?>
