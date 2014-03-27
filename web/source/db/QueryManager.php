<?PHP
	require_once(__DIR__ . '/../viskoapi/ViskoQuery.php');
	require_once('Manager.php');
	require_once(__DIR__ . '/../Query.php');
	
	/*************************************************
	* 
	* 
	*************************************************/
	class QueryManager extends Manager{

		public function insertQuery($query){
			$vq = $query->getViskoQuery();
	
			$conn = $this->getConnection();

			if(!($stmt = $conn->prepare("INSERT INTO `Query` (U_id, vsql, 
				targetFormatURI, targetTypeURI, viewURI, 
				viewerSetURI, artifactURL, dateSubmitted)
				VALUES(?, ?, ?, ?, ?, ?, ?, NOW())"))){
				$this->handlePrepareError($conn);
			}else{
				
				$stmt->bind_param('issssss',
					$query->getUserID(),
					$vq->getQueryText(),
					$vq->getTargetFormatURI(),
					$vq->getTargetTypeURI(),
					$vq->getViewURI(),
					$vq->getViewerSetURI(),
					$vq->getArtifactURL()
				);
				
				
				if(!$stmt->execute()){
					$this->handleExecuteError($stmt);
				}else{
				
					//get the insertion ID and set it in the query object.	
					$qid = $conn->insert_id;
						
					$query->setID($qid);
					return $qid;
					//TODO check for errors?
				}
				$stmt->close();
			}
		}

		
		/*
		* Updates a query object that is already in the database (valid id).
		* 
		* Sets everything except the user_id, id, and datesubmitted.
		*/
		public function updateQuery($query){
			$conn = $this->getConnection();
			
			$vq = $query->getViskoQuery();
		
			if(!($stmt = $conn->prepare("
				UPDATE Query SET
					vsql = ?, targetFormatURI = ?, targetTypeURI = ?,
					viewURI = ?, viewerSetURI = ?, artifactURL = ?
				WHERE id = ?"))){
				$this->handlePrepareError($conn);
			}else{
				$stmt->bind_param('ssssssi',
					$vq->getQueryText(),
					$vq->getTargetFormatURI(),
					$vq->getTargetTypeURI(),
					$vq->getViewURI(),
					$vq->getViewerSetURI(),
					$vq->getArtifactURL(),
					$query->getID()

				);	

				if(!$stmt->execute()){
					$this->handleExecuteError();
				}else{
					//good?
					return;
				}
			}
		}

		/**
		* Fetch a Query object from the database by its query id
		*
		* Builds the ViskoQuery instance also
		*
		*/
		public function getQueryByID($id){

			$conn = $this->getConnection();

			if(!($stmt = $conn->prepare("
			SELECT 
				U_id, vsql, targetFormatURI, targetTypeURI, 
				viewURI, viewerSetURI, artifactURL, dateSubmitted 
			FROM Query 
			WHERE Query.id = ?"))){
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
					$vq = new ViskoQuery();
					$vq->init($vsql, $targetFormatURI,
						$targetTypeURI, $viewURI, $viewerSetURI,
						$artifactURL);
					
					$query = new Query($uid, $vq, $dateSubmitted);
					$query->setID($id);
					return $query;
				}
			}

		}
	}
?>
