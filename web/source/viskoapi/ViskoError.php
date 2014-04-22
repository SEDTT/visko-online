<?php
require_once 'JsonDeserializable.php';

/**
* A simple wrapper around the errors generated from the java backend.
* @author awknaust
*/
class ViskoError{
	protected $type;
	protected $message;

	public function init($type, $message){
		$this->type = $type;
		$this->message = $message;
	}

	/**
	* @return String the type of this error (eq. to class in Java)
	*/
	public function getType(){
		return $this->type;
	}

	/**
	* @return String the message associated with this error.
	*/
	public function getMessage(){
		return $this->message;
	}

	public function fromJson($jobj){
		$this->type = $jobj->type;
		$this->message = $jobj->message;
	}
}
