<?PHP
	
	require_once __DIR__ . "/../Pipeline.php";
	require_once __DIR__ . "/../PipelineStatus.php";
	require_once __DIR__ . "/../viskoapi/ViskoPipelineStatus.php";
	require_once "Manager.php";

	/*****************************************************
	*
	*
	*****************************************************/
	class PipelineManager extends Manager{


		/**
		* Inserts a freshly made pipeline into the database and sets its ID.
		*
		* @param Pipeline pipeline -- a pipeline without an ID
		* @return int the id of the inserted pipeline.
		*/
		public function insertPipeline($pipeline){

            		$conn = $this->getConnection();
			$qid = $pipeline->getQueryID();	
			if(!($stmt = $conn->prepare("INSERT INTO Pipeline (queryID, viewURI, 
				viewerURI, toolkit, outputFormat, requiresInputURL)
				VALUES ( ?, ?, ?, ?, ?, ? )")
			)){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('issssi',
					$qid,
					$pipeline->getViewURI(),
					$pipeline->getViewerURI(),
					$pipeline->getToolkitURI(),
					$pipeline->getOutputFormat(),
					$pipeline->getRequiresInputURL()
				);
				
				if(!$stmt->execute()){
					$this->handleExecuteError();
				}else{
					$pid = $conn->insert_id;
					$pipeline->setID($pid);
					//TODO transaction coherency problems (fail to insert services = broken object)
					$this->insertServices($pipeline);
					$this->insertViewerSets($pipeline);
					return $pid;
				}
				$stmt->close();

			}
		}

		/*
		* Inserts all Services for a pipeline into the DB.
		*  
		* pre : $pipeline.getID() is valid
		*
		* @return true if no errors encountered, false otherwise
		*/
		private function insertServices($pipeline){
			$success = true;
			$services = $pipeline->getServices();
			$pid = $pipeline->getID();
			
			$conn = $this->getConnection();
			
			//TODO what if select fails? (This shouldnt be possible)
			if(!($stmt = $conn->prepare(
				"INSERT INTO PipelinexService (pipelineID, serviceID, 
					position)
				  SELECT ?, id, ? 
				  FROM Services 
				  WHERE URI = ?"))){
				$this->handlePrepareError($conn);
				$success = false;
			}else{
				//bind to variables and change variables
				$stmt->bind_param('iis', $pid, $pos, $serviceURI);
				

				//insert each service in the services array
				for($pos = 0; $pos < count($services); $pos++){
					$serviceURI = $services[$pos];
					//TODO better error handling...
					if(!$stmt->execute()){
						$success = false;
						$this->handleExecuteError($stmt);
					}
				}
				$stmt->close();
			}
			return $success;
		}

		/*
		* Inserts all ViewerSets for a pipeline into the DB.
		*  
		* pre : $pipeline.getID() is valid
		*
		* @return true if no errors encountered, false otherwise
		*/
		private function insertViewerSets($pipeline){
			$success = true;
			$viewerSets = $pipeline->getViewerSets();
			$pid = $pipeline->getID();
			
			$conn = $this->getConnection();
			
			if(!($stmt = $conn->prepare(
				"INSERT INTO PipelinexViewerSet (pipelineID, ViewerSetID)
				  SELECT ?, id 
				  FROM ViewerSets 
				WHERE URI = ? "))){
				$this->handlePrepareError($conn);
				$success = false;
			}else{
				//bind to variables and change variables
				$stmt->bind_param('is', $pid, $viewerSetURI);

				//insert each service in the services array
				for($pos = 0; $pos < count($viewerSets); $pos++){
					$viewerSetURI = $viewerSets[$pos];
					
					//TODO better error handling...
					if(!$stmt->execute()){
						$success = false;
						$this->handleExecuteError($stmt);
					}
				}
				$stmt->close();
			}
			return $success;
		}

		/* Retrieve a Pipeline object with the given ID from the database */
		public function getPipelineByID($pid){
			$conn = $this->getConnection();

			if(!($stmt = $conn->prepare(
				"SELECT queryID, viewURI, viewerURI, outputFormat, 
					toolkit, requiresInputURL
				FROM Pipeline
				WHERE id = ?"))){
				$this->handlePrepareError($conn);	
			}else{
				$stmt->bind_param('i', $pid);
				
				if(!$stmt->execute()){
					$this->handlePrepareError($stmt);
				}else{
					//TODO pipeline doesn't exist?
					//first get general information
					$stmt->bind_result($queryID, $viewURI, $viewerURI,
						$outputFormat, $toolkit, $requiresInputURL);
					
					//TODO error?
					while($stmt->fetch()){
					};

					//get services and viewersets
					$services = $this->collectServices($pid);
					$viewerSets = $this->collectViewerSets($pid);
					
					$pipe = new Pipeline($queryID, $viewURI,
						$viewerURI, $toolkit, $requiresInputURL, $outputFormat,
						$services, $viewerSets,
						$pid);
				
					//TODO move this
					$stmt->close();
					return $pipe;
				}

				$stmt->close();
			}
		}

		
		/*
		* Returns an array of ViewerSet URIs associated with a pipeline (id)
		*/
		private function collectViewerSets($pid){

			$conn = $this->getConnection();
			
			/* Get all Viewersets for this pipeline and ignore order.
			 */
			if(!($stmt = $conn->prepare(
				"SELECT ViewerSets.URI
				 FROM PipelinexViewerSet JOIN ViewerSets
				 	ON PipelinexViewerSet.viewerSetID = ViewerSets.id
				 WHERE PipelinexViewerSet.pipelineID = ?"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('i', $pid);

				if(!$stmt->execute()){
					//TODO this is bad
					$this->handleExecuteError($stmt);
				}else{
					//stuff results into an array
					$stmt->bind_result($viewerSetURI);
					$viewerSets = array();
					while($stmt->fetch()){
						array_push($viewerSets, $viewerSetURI);
					}
					$stmt->close();
					return $viewerSets;
				}
				$stmt->close();
			}
			
		}

		/*
		* Returns an array of service URIs associated with a pipeline (id)
		*/
		private function collectServices($pid){

			$conn = $this->getConnection();
			
			/* Get all Service URIs for this pipeline and order them
			 by their initial ordering
			 */
			if(!($stmt = $conn->prepare(
				"SELECT Services.URI
				 FROM PipelinexService JOIN Services
				 	ON PipelinexService.serviceID = Services.id
				 WHERE PipelinexService.pipelineID = ?
				 ORDER BY PipelinexService.position ASC"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('i', $pid);

				if(!$stmt->execute()){
					//TODO this is bad
					$this->handleExecuteError($stmt);
				}else{
					//stuff results into an array
					$stmt->bind_result($serviceURI);
					$services = array();
					while($stmt->fetch()){
						array_push($services, $serviceURI);
					}
					$stmt->close();
					return $services;
				}
				$stmt->close();
			}
			
		}

		/*
			Get a pipelinestatus for this pipeline. It will be null
			if the pipeline has not been executed.
		*/
		public function getPipelineStatus($pipeline){
			$conn = $this->getConnection();
			
			if(!($stmt = $conn->prepare(
				"SELECT id, resultURL, pipelineState, stateMessage,
					serviceIndex, serviceURI, completedNormally,
					dateExecuted
				FROM PipelineExecution
				WHERE pipelineID = ?"))){
				return $this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('i', $pipeline->getID());

				if(!$stmt->execute()){
					$this->handleExecuteError($stmt);
				}else{
					if($stmt->num_rows != 1)
						return null;

					$stmt->bind_result(
						$id, $resultURL, $pipelineState, $stateMessage,
						$serviceIndex, $serviceURI, $completedNormally,
						$dateExecuted
					);
					
					while($stmt->fetch()){
						;
					}
	 

					$vps = new ViskoPipelineStatus(
						$completedNormally,
					 	$resultURL,
				 		$serviceIndex,
						$serviceURI,
			 			$pipelineState,
			 			$stateMessage
					);

					$pipeStatus = new Pipeline($pipeline->getID(),
						$vps, $id, $dateExecuted);
					$stmt->close();
					return $pipeStatus;
				}
				$stmt->close();
			}
		}
	}
?>
