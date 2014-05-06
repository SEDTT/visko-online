<?php

require_once 'viskoapi/ViskoPipelineStatus.php';

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
	
		/**
		* Construct a PipelineStatus from variables.
		* 
		* @param pipelineID int the integer of the pipeline that this status describes
		* @param completedNormally boolean if the pipeline completed normally
		* @param resultURL String URL of visualization
		* @param serviceIndex int position of last-attempted service in pipeline
		* @param dateExecuted Date the date it was executed
		* @param id int the database ID of this object.
		*/
		public function __construct($pipelineID, $completedNormally=false, 
			$resultURL=null, $serviceIndex=null, $dateExecuted = null,
			$id = null
			){
			
			$this->pipelineID = $pipelineID;
			$this->id = $id;
			
			if($dateExecuted == null){
				$dateExecuted = new DateTime();
			}else{
				$this->dateExecuted = $dateExecuted;
			}

			$vps = new ViskoPipelineStatus();

			$vps->init($completedNormally, $resultURL, $serviceIndex);

			$this->viskoPipelineStatus = $vps;
		}

		public function getID(){
			return $this->id;
		}

		
		private function getViskoPipelineStatus(){
			return $this->viskoPipelineStatus;		
		}

		public function getPipelineID(){
			return $this->pipelineID;
		}

		public function getDateExecuted(){
			return $this->dateExecuted;
		}
		
		/**
		* Set the database of this pipelineStatus object.
		*/
		public function setID($id){
			$this->id = $id;
		}
		
		public function setDateExecuted(){
			$this->dateExecuted = dateExecuted;
		}

////////////Forwarded Methods ///////////////////

		/**
		* @return boolean if this pipeline execution reached its final state
		*	if false the pipeline completed with an error.
		*/
		public function completedNormally(){
			return $this->getViskoPipelineStatus()->getCompletedNormally();
		}

		/**
		* @return String get the URL of the resulting visualization, or null if !hasResult()
		*/
		public function getResultURL(){
			if($this->completedNormally()){
				return $this->getViskoPipelineStatus()->getResultURL();
			}
			return null;
		}

		/**
		* @return int the index of the last attempted service relative to the generating pipeline.
		*/
		public function getLastServiceIndex(){
			return $this->getViskoPipelineStatus()->getServiceIndex();
		}
	}


