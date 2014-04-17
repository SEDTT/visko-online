<?php
require_once 'JsonDeserializable.php';

/**
	Class that is the response from the backends execution of
	a pipeline. Is Serialized from the JSON response.
	
	@author awknaust
*/
class ViskoPipelineStatus implements JsonDeserializable{
	private $completedNormally;
	private $resultURL;
	private $serviceIndex; //index of executing/executed service in pipeline
	private $serviceURI; 
	private $pipelineState;
	private $stateMessage;
	

	public function init($completedNormally=false,
		$resultURL = null, $serviceIndex = null,
		$serviceURI = null, $pipelineState = null,
		$stateMessage = null
	){
		$this->completedNormally = $completedNormally;
		$this->resultURL = $resultURL;
		$this->serviceIndex = $serviceIndex;
		$this->pipelineState = $pipelineState;
		$this->serviceURI = $serviceURI;
		$this->stateMessage = $stateMessage;
	
	}

	/**
		Return whether the pipeline generated a visualization.	

		@return bool
	*/
	public function getCompletedNormally(){
		return $this->completedNormally;
	}

	/**
		Return the URL of the final visualization. Only
		valid if getCompletedNormally() == true.

		@return string
	*/
	public function getResultURL(){
		return $this->resultURL;
	}
	
	/**
		Return the index (w.r.t. the pipeline) of the executing
		service. 0 if not yet running

		@return int
	*/
	public function getServiceIndex(){
		return $this->serviceIndex;
	}

	/**
		Returns the URI of the currently executing service,
		unless the state is complete.

		@return string
	*/	
	public function getServiceURI(){
		return $this->serviceURI;
	}

	/**
		Returns one of the following:
			NODATA -- Input data already visualizable.
			EMPTYPIPELINE -- No services in pipeline
			RUNNING -- Running/waiting for service
			COMPLETE -- Execution Complete
			ERROR -- Exception found while running
			NEW -- Pipeline just created, not yet running.
			INTERRUPTED

		@return string
	*/
	public function getPipelineState(){
		return $this->pipelineState;
	}

	/**
		Get a descriptive message about the pipeline State.
		This comes directly from the Visko API
	
		@return string
	*/
	public function getStateMessage(){
		return $this->stateMessage;
	}

	public function fromJson($jobj){
		$this->completedNormally = $jobj->completedNormally;
		$this->pipelineState = $jobj->pipelineState;
		$this->stateMessage = $jobj->stateMessage;
		$this->serviceURI = $jobj->serviceURI;
		$this->serviceIndex = $jobj->serviceIndex;
		$this->resultURL = $jobj->resultURL;	
	}
}
