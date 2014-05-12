<?php

/**
 * Main abstract class for Error hierarchy.
 * @author awknaust
 *
 */
abstract class Error extends Exception {
	protected $userID;
	protected $timeOccurred;
	protected $id;

	public function __construct($userID, $timeOccurred = null, $id = null) {
		parent::__construct ();
		
		$this->userID = $userID;
		
		if ($timeOccurred == null) {
			$this->timeOccurred = new DateTime ();
		} else {
			$this->timeOccured = $timeOccurred;
		}
		
		$this->id = $id;
	}

	/**
	 * Set this Error's database ID
	 * 
	 * @param int $id
	 *        	new unique database ID
	 */
	public function setID($id) {
		$this->id = $id;
	}

	/**
	 *
	 * @return int This Error's database id
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * set this Error's message
	 * 
	 * @param String $message        	
	 */
	protected function setMessage($message) {
		$this->message = $message;
	}

	/**
	 *
	 * @return int the ID of the user that caused this error.
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 *
	 * @return DateTime the time this error occurred.
	 */
	public function getTimeOccurred() {
		return $this->timeOccurred;
	}
}
