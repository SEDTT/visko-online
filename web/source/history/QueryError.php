<?php
require_once 'Error.php';

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

class SyntaxError extends QueryError{
}

class MalformedURIError extends QueryError{
	
}

class NoPipelineResultsError extends QueryError{
	
}