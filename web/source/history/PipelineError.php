<?php
require_once 'Error.php';

/**
 * Top of Error Hierarchy for errors that occurred during pipeline execution.
 * @author awknaust
 *
 */
abstract class PipelineError extends Error{
	protected $pipelineID;
	
	public function __construct($userID, $pipelineID, $timeOccurred=null, $id=null){
		parent::__construct($userID, $timeOccurred, $id);
		$this->pipelineID = $pipelineID;
	}
	
	/**
	 * @return int the ID of the pipeline that caused this error.
	 */
	public function getPipelineID(){
		return $this->pipelineID;
	}
	
	
}

/**
 * Another abstract error type for pipelineErrors that can be traced to
 * a single service within the pipeline.
 * @author awknaust
 *
 */
abstract class ServiceError extends PipelineError{
	protected $serviceIndex;
	protected $serviceURI;
	
	public function __construct($userID, $pipelineID, $serviceIndex, $serviceURI, 
			 $timeOccurred = null, $id = null){
		parent::__construct($userID, $pipelineID, $timeOccurred, $id);
		$this->serviceURI = $serviceURI;
		$this->serviceIndex = $serviceIndex;
	}
	
	/**
	 * @return int the index of the service within the pipeline that caused the error.
	 */
	public function getServiceIndex(){
		return $this->serviceIndex;
	}
	
	/**
	 * @return String the URI of the service within the pipeline that caused the error.
	 */
	public function getServiceURI(){
		return $this->serviceURI;
	}
	
}

/**
 * A concrete Service Error created if a service cannot be executed 
 * (i.e. it responds with HTTP 404)
 * @author awknaust
 *
 */
class ServiceExecutionError extends ServiceError{
	protected $code = 1;
	
	public function __construct($userID, $pipelineID, $serviceIndex, $serviceURI, 
			 $timeOccurred = null, $id = null){
		parent::__construct($userID, $pipelineID, $serviceIndex, $serviceURI,
				 $timeOccurred, $id);
		
		$this->setMessage('Failed to execute Service #'. $this->serviceIndex . '(' . $this->serviceURI .')');
	}
	
}

/**
 * A concrete ServiceError created if service execution times out (takes too long to complete,
 * may indicate service is unreachable)
 * @author awknaust
 *
 */
class ServiceTimeoutError extends ServiceError{
	protected $code = 2;
	
	public function __construct($userID, $pipelineID, $serviceIndex, $serviceURI,
			 $timeOccurred = null, $id = null){
		parent::__construct($userID, $pipelineID, $serviceIndex, $serviceURI,
				 $timeOccurred, $id);
	
		$this->setMessage('Service #' . $this->serviceIndex . '(' . $this->serviceURI . ') timed out while executing.');
	}
	
}

/**
 * A concrete PipelineExecutionError created if the inputdata for a Pipeline cannot be
 * accessed
 * @author awknaust
 *
 */
class InputDataURLError extends PipelineError{
	protected $datasetURL;
	protected $code = 3;
	
	public function __construct($userID, $pipelineID, $datasetURL, 
			 $timeOccurred = null, $id = null){
		parent::__construct($userID, $pipelineID, $timeOccurred, $id);
		$this->datasetURL = $datasetURL;
		
		$this->setMessage('Bad Input Data URL (' . $this->datasetURL . ')');
	}
	
	/**
	 * @return String the URL of the dataset that caused the error.
	 */
	public function getDatasetURL(){
		return $this->datasetURL;
	}

}