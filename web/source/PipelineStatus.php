<?php

	/**
	* The status of a pipeline that was executed.
	*
	* Wraps a ViskoPipelineStatus that has the result, etc. And
	* includes a date that it was executed.
	* @author awknaust 
	*/
	class PipelineStatus{
		private $id;
		private $pipelineID;
		private $viskoPipelineStatus;
		private $dateExecuted;	
	
		public function __construct($pipelineID, $vps,
			 $dateExecuted = null, $id = null){
			
			$this->pipelineID = $pipelineID;
			$this->viskoPipelineStatus = $vps;
			$this->id = $id;
			$this->dateExecuted = $dateExecuted;
		}

		public function getID(){
			return $this->id;
		}

		public function getViskoPipelineStatus(){
			return $this->viskoPipelineStatus;		
		}

		public function getPipelineID(){
			return $this->pipelineID;
		}

		public function getDateExecuted(){
			return $this->dateExecuted;
		}
		
		public function setID($id){
			$this->id = $id;
		}
		
		public function setDateExecuted(){
			$this->dateExecuted = dateExecuted;
		}
	}


