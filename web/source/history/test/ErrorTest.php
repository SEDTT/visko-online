<?php
require_once __DIR__ . '/../Error.php';

class StubError extends Error{
	
	public function sm($message){
		$this->setMessage($message);
	}	
}

class ErrorTest extends PHPUnit_Framework_TestCase{

	public function testConstructor(){
		$d1 = new DateTime();
		$e = new StubError(8, $d1, 3);
		
		$this->assertEquals(3, $e->getID());
		$this->assertEquals(8, $e->getUserID());
		$this->assertEquals($d1, $e->getTimeOccurred());
		
		$e1 = new StubError(5);
		$this->assertEquals(5, $e->getID());
		
	}
	
	public function testSetID(){
		$e = new StubError(1);
		
		$e->setID(7);
		$this->assertEquals(7, $e->getID());
	}
	
	public function testSetMessage(){
		$e = new StubError(1);
		$e->sm("");
		
		$this->assertEquals("", $e->getMessage());
		
		$e->sm("Hello World");
		$this->assertEquals("Hello World", $e->getMessage());
	}
}