<?php

/**
* Partially wrap legacy User code to resemble something object oriented...
*/
class User {
	protected $id;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getID() {
		return $this->id;
	}

	public function setID($id) {
		$this->id = $id;
	}
}
