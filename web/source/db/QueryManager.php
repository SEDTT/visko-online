<?PHP
require_once ('Manager.php');
require_once (__DIR__ . '/../Query.php');

/**
 * Manage Query objects and fields (storing and retrieving from database)
 *
 * @author awknaust
 *        
 */
class QueryManager extends Manager {

	/**
	 * Inserts a query object and all accompanying data into the database.
	 * Also sets this query's id from an auto-generated database value
	 *
	 * @param $query a
	 *        	Query object (inout)
	 * @return int the query objects new ID
	 */
	public function insertQuery($query) {
		assert ( $query->getDateSubmitted () != null );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `Queries` (userID, vsql, 
				typeURI, formatURI, targetFormatURI, targetTypeURI, viewURI, 
				viewerSetURI, artifactURL, dateSubmitted)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?))" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'issssssssi', $query->getUserID (), $query->getTypeURI (), $query->getFormatURI (), $query->getQueryText (), $query->getTargetFormatURI (), $query->getTargetTypeURI (), $query->getViewURI (), $query->getViewerSetURI (), $query->getArtifactURL (), $query->getDateSubmitted ()->getTimestamp () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				
				// get the insertion ID and set it in the query object.
				$qid = $conn->insert_id;
				
				$query->setID ( $qid );
				
				// once the ID is set we can go ahead and insert parameters
				if ($query->getParameterBindings () != null && count ( $query->getParameterBindings () ) > 0) {
					
					$this->insertQueryParameters ( $query );
				}
				return $qid;
				// TODO check for errors?
			}
			$stmt->close ();
		}
	}

	/**
	 * Updates a query object that is already in the database (valid id).
	 *
	 * Sets everything except the id
	 * Drop parameters and then readd any new ones
	 *
	 * @param Query $query
	 *        	a query object in the database to update.
	 * @throws ManagerException if $query isn't already in database (bad id)
	 */
	public function updateQuery($query) {
		assert ( $query->getID () > 0 ); // already in DB
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
				UPDATE `Queries` SET
					vsql = ?, typeURI = ?, formatURI = ?, targetFormatURI = ?, targetTypeURI = ?,
					viewURI = ?, viewerSetURI = ?, artifactURL = ?,
					userID = ?, dateSubmitted = FROM_UNIXTIME(?)
				WHERE id = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( 'ssssssssiii', $query->getQueryText (), $query->getTypeURI (), $query->getFormatURI (), $query->getTargetFormatURI (), $query->getTargetTypeURI (), $query->getViewURI (), $query->getViewerSetURI (), $query->getArtifactURL (), $query->getUserID (), $query->getDateSubmitted ()->getTimestamp (), $query->getID () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else if ($conn->affected_rows <= 0) {
				throw new ManagerException ( 'Failed to update probably due to bad query id ' . $query->getID () );
			} else {
				// update parameters by delete/add
				$this->deleteQueryParameters ( $query );
				$this->insertQueryParameters ( $query );
			}
			$stmt->close ();
		}
	}

	/**
	 * Delete all query parameters for a given query
	 */
	private function deleteQueryParameters($query) {
		$conn = $this->getConnection ();
		$qid = $query->getID ();
		
		if (! ($stmt = $conn->prepare ( "DELETE
				 FROM `QueryParameters`
				 WHERE queryID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( 'i', $qid );
			
			if (! $stmt->execute ()) {
				// TODO this is bad
				$this->handleExecuteError ( $stmt );
			}
			$stmt->close ();
		}
	}

	/**
	 *
	 * @return array(String, String) of URI, value pairs of all parameters associated
	 *         with the query with given query ID.
	 */
	private function collectQueryParameters($qid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "SELECT URI, value
				 FROM QueryParameters
				 WHERE queryID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( 'i', $qid );
			
			if (! $stmt->execute ()) {
				// TODO this is bad
				$this->handleExecuteError ( $stmt );
			} else {
				// stuff results into an array/map
				$stmt->bind_result ( $paramURI, $paramValue );
				$parameterBindings = array ();
				
				while ( $stmt->fetch () ) {
					$parameterBindings [$paramURI] = $paramValue;
				}
				$stmt->close ();
				return $parameterBindings;
			}
			$stmt->close ();
		}
	}

	/**
	 * Insert the Query parameters into the QueryParameters table
	 *
	 * Assumes that $query has a valid set of parameters, and a valid ID
	 */
	private function insertQueryParameters($query) {
		$conn = $this->getConnection ();
		$success = true;
		
		$qid = $query->getID ();
		
		// TODO what if select fails? (This shouldnt be possible)
		if (! ($stmt = $conn->prepare ( "INSERT INTO QueryParameters (queryID, URI, value) 
				  VALUES ( ?, ?, ?)" ))) {
			$this->handlePrepareError ( $conn );
			$success = false;
		} else {
			// bind to variables and change variables
			$stmt->bind_param ( 'iss', $qid, $paramURI, $paramValue );
			
			// insert each uri, value pair for parameters into DB
			foreach ( $query->getParameterBindings () as $paramURI => $paramValue ) {
				if (! $stmt->execute ()) {
					$success = false;
					$this->handleExecuteError ( $stmt );
				}
			}
			$stmt->close ();
		}
		return $success;
	}

	/**
	 * Fetch a Query object from the database by its query id
	 *
	 * @param int $id
	 *        	id of the query to retrieve
	 * @return Query the query object associated with $id
	 * @throws ManagerException if $id doesn't reference a Query in the database.
	 */
	public function getQueryByID($id) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT 
				userID, vsql, targetFormatURI, targetTypeURI, formatURI, typeURI,
				viewURI, viewerSetURI, artifactURL, dateSubmitted 
			FROM Queries 
			WHERE Queries.id = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $id );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $uid, $vsql, $formatURI, $typeURI, $targetFormatURI, $targetTypeURI, $viewURI, $viewerSetURI, $artifactURL, $dateSubmitted );
				
				while ( $stmt->fetch () ) {
					;
				}
				
				if ($uid == null) {
					throw new ManagerException ( 'No Query with id ' . $id );
				} else {
					$parameterBindings = $this->collectQueryParameters ( $id );
					
					$query = new Query ( $uid, $vsql, $formatURI, $typeURI, $targetFormatURI, $targetTypeURI, $viewURI, $viewerSetURI, $artifactURL, $parameterBindings, new DateTime ( $dateSubmitted ), $id );
				}
				return $query;
			}
		}
	}

	/**
	 * Get a list of unique input URLs for all Queries submitted by a given user.
	 *
	 * @param int $uid
	 *        	id of user
	 * @return array(String)
	 */
	public function getUserInputURLs($uid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT DISTINCT artifactURL
			FROM Queries
			WHERE userID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $uid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $row );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					if ($row != null) {
						$data [] = $row;
					}
				}
				$stmt->close ();
				return $data;
			}
		}
	}

	/**
	 * Get a list of unique typeURIs for all Queries submitted by a given user.
	 *
	 * @param int $uid
	 *        	id of user
	 * @return array(String)
	 */
	public function getUserInputTypes($uid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT DISTINCT typeURI
			FROM Queries
			WHERE userID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $uid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $row );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					if ($row != null) {
						$data [] = $row;
					}
				}
				$stmt->close ();
				return $data;
			}
		}
	}

	/**
	 * Get a list of unique formatURIs for all Queries submitted by a given user.
	 *
	 * @param int $uid
	 *        	id of user
	 * @return array(String)
	 */
	public function getUserInputFormats($uid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT DISTINCT formatURI
			FROM Queries
			WHERE userID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $uid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $row );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					if ($row != null) {
						$data [] = $row;
					}
				}
				$stmt->close ();
				return $data;
			}
		}
	}

	/**
	 * Get a list of unique viewURIs for all Queries submitted by a given user.
	 *
	 * @param int $uid
	 *        	id of user
	 * @return array(String)
	 */
	public function getUserAbstractions($uid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT DISTINCT viewURI
			FROM Queries
			WHERE userID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $uid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $row );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					if ($row != null) {
						$data [] = $row;
					}
				}
				$stmt->close ();
				return $data;
			}
		}
	}

	/**
	 * Get a list of unique viewerSetURIs for all Queries submitted by a given user.
	 *
	 * @param int $uid
	 *        	id of user
	 * @return array(String)
	 */
	public function getUserViewerSets($uid) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT DISTINCT viewerSetURI
			FROM Queries
			WHERE userID = ?" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$stmt->bind_param ( "i", $uid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $row );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					if ($row != null) {
						$data [] = $row;
					}
				}
				$stmt->close ();
				return $data;
			}
		}
	}

	/**
	 * Search for visualizations performed by a given user based on various criteria.
	 * Pass any of the parameters as null to have them ignored in the search query.
	 *
	 * Current version only returns completed visualizations (not unsubmitted or errored).
	 *
	 * @param int $uid
	 *        	id of the user
	 * @param string $typeURI        	
	 * @param string $formatURI        	
	 * @param string $viewURI        	
	 * @param string $viewerSetURI        	
	 * @param string $inputURL        	
	 * @param string $startDate        	
	 * @param string $endDate        	
	 * @return array(array(int, boolean, String)) An array of (pipelineID, completedNormally, resultURL) tuples matching the search criteria.
	 */
	public function searchUserQueries($uid, $typeURI = null, $formatURI = null, $viewURI = null, $viewerSetURI = null, $inputURL = null, $startDate = null, $endDate = null) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "
			SELECT Pipelines.id, PipelineStatuses.completedNormally, PipelineStatuses.resultURL
			FROM (Queries JOIN Pipelines ON Queries.id = Pipelines.queryID) JOIN
				PipelineStatuses ON PipelineStatuses.pipelineID = Pipelines.id
			WHERE Queries.userID = ?
			AND (? IS NULL OR Queries.typeURI = ?)
			AND (? IS NULL OR Queries.formatURI = ?)
			AND (? IS NULL OR Queries.viewURI = ?)
			AND (? IS NULL OR Queries.viewerSetURI = ?)
			AND (? IS NULL OR Queries.dateSubmitted > FROM_UNIXTIME(?))
			AND (? IS NULL OR Queries.dateSubmitted < FROM_UNIXTIME(?))
			AND (? IS NULL OR Queries.artifactURL = ?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			$startDate = ($startDate == null) ? null : $startDate->getTimestamp ();
			$endDate = ($endDate == null) ? null : $endDate->getTimestamp ();
			
			$stmt->bind_param ( "issssssssssssss", $uid, $typeURI, $typeURI, $formatURI, $formatURI, $viewURI, $viewURI, $viewerSetURI, $viewerSetURI, $startDate, $startDate, $endDate, $endDate, $inputURL, $inputURL );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$stmt->bind_result ( $pipelineID, $completedNormally, $resultURL );
				
				$data = [ ];
				while ( $stmt->fetch () ) {
					$data [] = [ 
							$pipelineID,
							$completedNormally,
							$resultURL 
					];
				}
				$stmt->close ();
				return $data;
			}
		}
	}
}

