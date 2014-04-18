<?PHP
require_once 'Manager.php';
require_once __DIR__ . '/../history/Error.php';
require_once __DIR__ . '/../history/PipelineError.php';
require_once __DIR__ . '/../history/QueryError.php';

class ErrorManager extends Manager{

	private $handlerTable = [];

	public function __construct(){
		parent::__construct();

		//register error handlers for different classes.
		$this->registerHandler('MalformedURIError', new MalformedURIErrorHandler($this));
	}
	
	private function registerHandler($cls, $handler){
		$this->handlerTable[$cls] = $handler;
	}

	/**
	* @param error Error some subclass of Error with a registered handler.
	*/
	public function insertError($error){
	
		//check if we have a handler registered for this error's type
		// and call its store method to save it.
		// this is a poor-man's polymorphism.
		$found = false;
		foreach($this->handlerTable as $cls => $handler){
			if(get_class($error) == $cls){
				$handler->store($error);
			}
			$found = true;
			break;
		}
		
		if(!$found){
			throw Exception('Unsupported error type');
		}
	}
}

abstract class ErrorHandler{
	private $manager;
	
	public function __construct($manager){
		$this->manager = $manager;
	}

	/**
	*
	* @return int the ID of this insertion.
	*/ 
	public function store($error){
		$conn = $this->getConnection();

		if(!($stmt = $conn->prepare("INSERT INTO `Errors` (userID, message, 
			timeOccurred)
			VALUES(?, ?, NOW())"))){
			$this->handlePrepareError($conn);
		}else{
			
			$stmt->bind_param('is',
				$error->getUserID(),
				$error->getMessage()
			);
			
			
			if(!$stmt->execute()){
				$this->handleExecuteError($stmt);
			}else{
			
				//get the insertion ID and set it in the query object.	
				$eid = $conn->insert_id;
				$error->setID($eid);

			}
			$stmt->close();
			return $eid;
		}
		$stmt->close();

	}

	/*
	* @return the mysqli connection to be used
	*/
	protected function getConnection(){
		return $this->manager->getConnection();
	}


}

abstract class QueryErrorHandler extends ErrorHandler{


	public function store($error){
		//store the parent Error and we can reference it
		$pid = parent::store($error);
		
		$conn = $this->getConnection();

		if(!($stmt = $conn->prepare("INSERT INTO `QueryErrors` (parentID, queryID)
			VALUES(?, ?)"))){
			$this->handlePrepareError($conn);
		}else{
			
			$stmt->bind_param('ii',
				$pid,
				$error->getQueryID()
			);
			
			
			if(!$stmt->execute()){
				$this->handleExecuteError($stmt);
			}else{
				$eid = $conn->insert_id;

			}
			$stmt->close();
			return $eid;
		}
		$stmt->close();
	}
}

class MalformedURIErrorHandler extends QueryErrorHandler{
	
	public function store($error){
		//store the parent Error and we can reference it
		$pid = parent::store($error);
		
		$conn = $this->getConnection();

		if(!($stmt = $conn->prepare("INSERT INTO `MalformedURIErrors` (parentID, uri)
			VALUES(?, ?)"))){
			$this->handlePrepareError($conn);
		}else{
			
			$stmt->bind_param('is',
				$pid,
				$error->getURI()
			);
			
			
			if(!$stmt->execute()){
				$this->handleExecuteError($stmt);
			}else{
				$eid = $conn->insert_id;

			}
			$stmt->close();
			return $eid;
		}
		$stmt->close();
	}

}


