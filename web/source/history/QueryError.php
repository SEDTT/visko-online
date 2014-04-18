<?php
require_once 'Error.php';

/**
* QueryErrors are errors that result from attempting to generate pipelines from a query.
*/
abstract class QueryError extends Error{
	protected $queryID;
	
	public function __construct($userID, $queryID, $timeOccurred=null, $id=null){
		parent::__construct($userID, $timeOccurred, $id);
		$this->queryID = $queryID;
	}
	
	public function getQueryID(){
		return $this->queryID;
	}
}

/**
* A concrete QueryError resulting from a syntax error in the Query text.
* TODO : Enhance error reporting information.
*/
class SyntaxError extends QueryError{
	protected $code = 4;

	public function __construct($userID, $queryID, $timeOccurred=null, $id=null){
		parent::__construct($userID, $queryID, $timeOccurred, $id);
		$this->setMessage("Syntax Error in pipeline");
	}
}

/**
* A concrete QueryError stemming from a malformed URI within the query text.
*/
class MalformedURIError extends QueryError{
	protected $uri;
	protected $code = 5;

	public function __construct($userID, $queryID, $uri, $timeOccurred=null, $id=null){
		parent::__construct($userID, $queryID, $timeOccurred, $id);
		$this->uri = $uri;
		$this->setMessage('Query contains malformed URI (' . $uri . ')');
	}

	public function getURI(){
		return $this->uri;
	}
}

/**
* A concrete QueryError stemming from a Query that failed to generate pipelines.
*/
class NoPipelineResultsError extends QueryError{
	protected $code = 6;

	public function __construct($userID, $queryID, $timeOccurred=null, $id=null){
		parent::__construct($userID, $queryID, $timeOccurred, $id);
		$this->setMessage("Query generated 0 pipelines");
	}
}
