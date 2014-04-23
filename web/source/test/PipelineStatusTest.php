<?php
require_once __DIR__ . '/../PipelineStatus.php';

/**
 * Test PipelineStatus objects.
 * 
 * @author awknaust
 *
 */
class PipelineStatusTest extends PHPUnit_Framework_TestCase{


	public function testConstructor(){
		$pipelineID = 1;
		$completedNormally = true;
		$resultURL = "http://myspace.com/hello.jpg";
		$serviceIndex = 0;
		$dateExecuted = new DateTime();
		$id = 3;

		$ps = new PipelineStatus(
				$pipelineID,
				$completedNormally,
				$resultURL,
				$serviceIndex,
				$dateExecuted,
				$id
		);

		$this->assertEquals($pipelineID, $ps->getPipelineID());
		$this->assertEquals($completedNormally, $ps->completedNormally());
		$this->assertEquals($resultURL, $ps->getResultURL());
		$this->assertEquals($serviceIndex, $ps->getLastServiceIndex());
		$this->assertEquals($dateExecuted, $ps->getDateExecuted());
		$this->assertEquals($id, $ps->getID());
	}
}