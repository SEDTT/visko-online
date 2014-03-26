<?PHP
	
	require_once __DIR__ . "/../source/viskoapi/ViskoPipeline.php";
	require_once "Pipeline.php";
	require_once 'Manager.php';

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
		public function insertPipeline($pipeline, $qid){

            		$conn = $this->getConnection();
			$vp = $pipeline->getViskoPipeline(); 
		
			if(!($stmt = $conn->prepare("INSERT INTO Pipeline (queryID, viewURI, 
				viewerURI, toolkit, outputFormat, requiresInputURL)
				VALUES ( ?, ?, ?, ?, ?, ? )")
			)){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('issssi',
					$qid,
					$vp->getViewURI(),
					$vp->getViewerURI(),
					$vp->getToolkitThatGeneratesView(),
					$vp->getOutputFormat(),
					$vp->getRequiresInputURL()
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
			$services = $pipeline->getViskoPipeline()->getServices();
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
				
				echo count($services);

				//insert each service in the services array
				for($pos = 0; $pos < count($services); $pos++){
					$serviceURI = $services[$pos];
					echo $serviceURI . '<br>';
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
			$viewerSets = $pipeline->getViskoPipeline()->getViewerSets();
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
					

					$vp = new ViskoPipeline();
					
					$vp->init($viewURI, $viewerURI,
						$toolkit, $requiresInputURL, $outputFormat,
						$services, $viewerSets
					);

					$pipe = new Pipeline($queryID, $vp, $pid);
				
					echo "here";
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

		//Fetch from PipelineExecutionTable
		public function getPipelineStatus($pipeline){

		}
	}
?>
