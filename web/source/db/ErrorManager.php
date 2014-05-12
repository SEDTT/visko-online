<?PHP
require_once 'Manager.php';
require_once __DIR__ . '/../history/Error.php';
require_once __DIR__ . '/../history/PipelineError.php';
require_once __DIR__ . '/../history/QueryError.php';

class ErrorManager extends Manager {
	private $handlerTable = [ ];

	public function __construct() {
		parent::__construct ();
		
		/*
		 * An error handler must be registered for each error type. Also register for abstract types since they can be counted, if not stored.
		 */
		$this->registerHandler ( 'Error', new ErrorHandler ( $this ) );
		
		$this->registerHandler ( 'QueryError', new QueryErrorHandler ( $this ) );
		$this->registerHandler ( 'MalformedURIError', new MalformedURIErrorHandler ( $this ) );
		$this->registerHandler ( 'SyntaxError', new SyntaxErrorHandler ( $this ) );
		$this->registerHandler ( 'NoPipelineResultsError', new NoPipelineResultsErrorHandler ( $this ) );
		
		$this->registerHandler ( 'PipelineError', new PipelineErrorHandler ( $this ) );
		$this->registerHandler ( 'InputDataURLError', new InputDataURLErrorHandler ( $this ) );
		$this->registerHandler ( 'ServiceError', new ServiceErrorHandler ( $this ) );
		$this->registerHandler ( 'ServiceTimeoutError', new ServiceTimeoutErrorHandler ( $this ) );
		$this->registerHandler ( 'ServiceExecutionError', new ServiceExecutionErrorHandler ( $this ) );
	}

	/**
	 * Register a handler for a certain class of error.
	 * Error handlers must implement the ErrorHandler interface.
	 *
	 * @param String $cls
	 *        	name of type that handler supports
	 * @param
	 *        	ErrorHandler an errorhandler object.
	 */
	private function registerHandler($cls, $handler) {
		$this->handlerTable [$cls] = $handler;
	}

	/**
	 *
	 * @param $error Error
	 *        	some subclass of Error with a registered handler.
	 * @throws ManagerException if failed to insert into DB or error is of unsupported type.
	 */
	public function insertError($error) {
		
		// check if we have a handler registered for this error's type
		// and call its store method to save it.
		// this is a poor-man's polymorphism.
		$clsName = get_class ( $error );
		if (array_key_exists ( $clsName, $this->handlerTable )) {
			$handler = $this->handlerTable [$clsName];
			$handler->store ( $error );
		} else {
			throw new ManagerException ( "Failed to insert error of unsupported type '" . $clsName . "'" );
		}
	}

	/**
	 * Counts the number of errors of a given type
	 *
	 * @param String $clsName
	 *        	name of error class as String
	 * @throws ManagerException
	 * @return int number of stored errors of the given type
	 */
	public function countErrors($clsName) {
		if (array_key_exists ( $clsName, $this->handlerTable )) {
			$handler = $this->handlerTable [$clsName];
			return $handler->countErrors ();
		} else {
			throw new ManagerException ( "Failed to count errors of unsupported type '" . $clsName . "'" );
		}
	}
}

/**
 * ErrorHandlers are responsible for inserting and potentially retrieving errors from
 * the database.
 * Because the Error classes are in a big hierarchy as are the error tables
 * these handlers depend on parent handlers to insert part of the parent error information.
 *
 * @author awknaust
 *        
 */
class ErrorHandler {
	private $manager;
	protected $TABLE = "Errors";

	public function __construct($manager) {
		$this->manager = $manager;
	}

	/**
	 * Insert this error into the database.
	 * Each store function must first call its parent store, and use the returned id
	 * as the parentID in the database to reference the parent error.
	 *
	 * @return int the ID of this insertion.
	 */
	public function store($error) {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `Errors` (userID, message, 
			timeOccurred)
			VALUES(?, ?, FROM_UNIXTIME(?))" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'isi', $error->getUserID (), $error->getMessage (), $error->getTimeOccurred ()->getTimestamp () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				
				// get the insertion ID and set it in the query object.
				$eid = $conn->insert_id;
				$error->setID ( $eid );
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
	// //////////Forward some messages to the manager ///////////
	/**
	 *
	 * @return the mysqli connection to be used
	 */
	protected function getConnection() {
		return $this->manager->getConnection ();
	}

	protected function handlePrepareError($conn) {
		return $this->manager->handlePrepareError ( $conn );
	}

	protected function handleExecuteError($stmt) {
		return $this->manager->handleExecuteError ( $stmt );
	}

	/**
	 *
	 * @return int the number of errors of this type.
	 * @throws ManagerException
	 */
	public function countErrors() {
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "SELECT COUNT(*) FROM `" . $this->TABLE . "`" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			if (! $stmt->execute ()) {
				$this->handlePrepareError ( $stmt );
			} else {
				$stmt->bind_result ( $cnt );
				
				while ( $stmt->fetch () ) {
				}
				;
				
				$stmt->close ();
				return $cnt;
			}
			
			$stmt->close ();
		}
	}
}

class QueryErrorHandler extends ErrorHandler {
	protected $TABLE = "QueryErrors";

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `QueryErrors` (parentID, queryID)
			VALUES(?, ?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'ii', $pid, $error->getQueryID () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class MalformedURIErrorHandler extends QueryErrorHandler {
	protected $TABLE = "MalformedURIErrors";

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `MalformedURIErrors` (parentID, uri)
			VALUES(?, ?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'is', $pid, $error->getURI () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class SyntaxErrorHandler extends QueryErrorHandler {
	protected $TABLE = "SyntaxErrors";

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `SyntaxErrors` (parentID)
			VALUES(?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'i', $pid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class NoPipelineResultsErrorHandler extends QueryErrorHandler {
	protected $TABLE = 'NoPipelineResultsErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `NoPipelineResultsErrors` (parentID)
			VALUES(?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'i', $pid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class PipelineErrorHandler extends ErrorHandler {
	protected $TABLE = 'PipelineErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `PipelineErrors` (parentID, pipelineID)
			VALUES(?, ?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'ii', $pid, $error->getPipelineID () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class ServiceErrorHandler extends PipelineErrorHandler {
	protected $TABLE = 'ServiceErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `ServiceErrors` (parentID, pipelineServiceID)
				SELECT ?, PipelineServices.id
				FROM PipelineServices
				WHERE PipelineServices.pipelineID = ?,
					AND PipelineServices.position = ?
				" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'iii', $pid, $pid, $error->getServiceIndex () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class ServiceTimeoutErrorHandler extends ServiceErrorHandler {
	protected $TABLE = 'ServiceTimeoutErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `ServiceTimeoutErrors` (parentID)
			VALUES(?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'i', $pid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class ServiceExecutionErrorHandler extends ServiceErrorHandler {
	protected $TABLE = 'ServiceExecutionErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `ServiceExecutionErrors` (parentID)
			VALUES(?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'i', $pid );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}

class InputDataURLErrorHandler extends PipelineErrorHandler {
	protected $TABLE = 'InputDataURLErrors';

	public function store($error) {
		// store the parent Error and we can reference it
		$pid = parent::store ( $error );
		
		$conn = $this->getConnection ();
		
		if (! ($stmt = $conn->prepare ( "INSERT INTO `InputDataURLErrors` (parentID, datasetURL)
			VALUES(?, ?)" ))) {
			$this->handlePrepareError ( $conn );
		} else {
			
			$stmt->bind_param ( 'is', $pid, $error->getDatasetURL () );
			
			if (! $stmt->execute ()) {
				$this->handleExecuteError ( $stmt );
			} else {
				$eid = $conn->insert_id;
			}
			$stmt->close ();
			return $eid;
		}
		$stmt->close ();
	}
}




