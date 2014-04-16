<?php

/**
 * Main abstract class for Error hierarchy.
 * @author awknaust
 *
 */
abstract class Error extends Exception{
	protected $userID;
	protected $timeOccurred;
	protected $id;
	
	public function __construct($userID, $timeOccurred=null, $id=null){
		parent::__construct();
		$this->userID = $userID;
		$this->timeOccured = $timeOccurred;
		$this->id = $id;
		
	}
	
	/**
	 * Set this Error's database ID
	 * @param int $id new unique database ID
	 */
	public function setID($id){
		$this->id = $id;
	}
	
	
	/**
	 * set this Error's message
	 * @param String $message
	 */
	protected function setMessage($message){
		$this->message = $message;
	}
	
	
}