<?PHP
	require_once('Manager.php');
	require_once(__DIR__ . '/../Query.php');
	
	/*************************************************
	* 
	* 
	*************************************************/
	class QueryManager extends Manager{

		/**
		* Inserts a query object and all accompanying data into the database.
		* Also sets this query's id from an auto-generated database value
		*
		* @param query a Query object (inout)
		* @return int the query objects new ID
		*/
		public function insertQuery($query){
	
			$conn = $this->getConnection();

			if(!($stmt = $conn->prepare("INSERT INTO `Queries` (userID, vsql, 
				targetFormatURI, targetTypeURI, viewURI, 
				viewerSetURI, artifactURL, dateSubmitted)
				VALUES(?, ?, ?, ?, ?, ?, ?, NOW())"))){
				$this->handlePrepareError($conn);
			}else{
				
				$stmt->bind_param('issssss',
					$query->getUserID(),
					$query->getQueryText(),
					$query->getTargetFormatURI(),
					$query->getTargetTypeURI(),
					$query->getViewURI(),
					$query->getViewerSetURI(),
					$query->getArtifactURL()
				);
				
				
				if(!$stmt->execute()){
					$this->handleExecuteError($stmt);
				}else{
				
					//get the insertion ID and set it in the query object.	
					$qid = $conn->insert_id;
						
					$query->setID($qid);

					//once the ID is set we can go ahead and insert parameters
					if($query->getParameterBindings() != null && 
						count($query->getParameterBindings()) > 0){
						
						$this->insertQueryParameters($query);
					}
					return $qid;
					//TODO check for errors?
				}
				$stmt->close();
			}
		}

		
		/*
		* @deprecated This shouldn't ever be necessary and doesnt update the parameters
		* Updates a query object that is already in the database (valid id).
		* 
		* Sets everything except the user_id, id, and datesubmitted.
		*/
		public function updateQuery($query){
			$conn = $this->getConnection();
			
			if(!($stmt = $conn->prepare("
				UPDATE Queries SET
					vsql = ?, targetFormatURI = ?, targetTypeURI = ?,
					viewURI = ?, viewerSetURI = ?, artifactURL = ?
				WHERE id = ?"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('ssssssi',
					$query->getQueryText(),
					$query->getTargetFormatURI(),
					$query->getTargetTypeURI(),
					$query->getViewURI(),
					$query->getViewerSetURI(),
					$query->getArtifactURL(),
					$query->getID()

				);	

				if(!$stmt->execute()){
					$this->handleExecuteError($stmt);
				}else{
					//good?
					return;
				}
			}
		}

		/**
		* @return array(String, String) of URI, value pairs of all parameters associated
			with the query with given query ID.
		*/
		private function collectQueryParameters($qid){
			
			$conn = $this->getConnection();
			
			if(!($stmt = $conn->prepare(
				"SELECT URI, value
				 FROM QueryParameters
				 WHERE queryID = ?"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('i', $qid);

				if(!$stmt->execute()){
					//TODO this is bad
					$this->handleExecuteError($stmt);
				}else{
					//stuff results into an array/map
					$stmt->bind_result($paramURI, $paramValue);
					$parameterBindings = array();
					
					while($stmt->fetch()){
						$parameterBindings[$paramURI] = $paramValue;
					}
					$stmt->close();
					return $parameterBindings;
				}
				$stmt->close();
			}
			
		}

		/** Insert the Query parameters into the QueryParameters table

		 Assumes that $query has a valid set of parameters, and a valid ID
		**/
		private function insertQueryParameters($query){
			$conn = $this->getConnection();
			$success = true;

			$qid = $query->getID();
			
			
			//TODO what if select fails? (This shouldnt be possible)
			if(!($stmt = $conn->prepare(
				"INSERT INTO QueryParameters (queryID, URI, value) 
				  VALUES ( ?, ?, ?)"))){
				$this->handlePrepareError($conn);
				$success = false;
			}else{
				//bind to variables and change variables
				$stmt->bind_param('iss', $qid, $paramURI, $paramValue);
				

				//insert each uri, value pair for parameters into DB
				foreach($query->getParameterBindings() as $paramURI => $paramValue){
					if(!$stmt->execute()){
						$success = false;
						$this->handleExecuteError($stmt);
					}
				}
				$stmt->close();
			}
			return $success;

		}

		/**
		* Fetch a Query object from the database by its query id
		*
		*
		*/
		public function getQueryByID($id){

			$conn = $this->getConnection();

			if(!($stmt = $conn->prepare("
			SELECT 
				userID, vsql, targetFormatURI, targetTypeURI, 
				viewURI, viewerSetURI, artifactURL, dateSubmitted 
			FROM Queries 
			WHERE Queries.id = ?"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param("i", $id);
				
				if(!$stmt->execute()){
					$this->handleExecuteError();
				}else{
					 $stmt->bind_result(
						$uid, $vsql, $targetFormatURI,
						$targetTypeURI, $viewURI, $viewerSetURI,
						$artifactURL, $dateSubmitted
					);	
				
					while($stmt->fetch()){
						;
					}
					
					$parameterBindings = $this->collectQueryParameters($id);
						
					$query = new Query($uid, $vsql, $targetFormatURI, $targetTypeURI,
						$viewURI, $viewerSetURI, $artifactURL, $parameterBindings,
						$dateSubmitted, $id);

					return $query;
				}
			}

		}
	}

