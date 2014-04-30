<?php
require_once 'JsonTransformer.php';
require_once 'JsonCerializable.php';

class ViskoQuery implements JsonCerializable{
	private $vsql;
	private $targetFormatURI;
	private $targetTypeURI;
	private $viewURI;
	private $viewerSetURI;
	private $artifactURL;
	
	public function __construct($queryText){
		$this->setQueryText($queryText);
	}
	
	public function getQueryText(){
		return $this->vsql;
	}
	
	public function setQueryText($queryText){
		$this->vsql = $queryText;
	}
	
	public function toJson(){
		$jt = new JsonTransformer;
		$attrs = array(
			"type" => "Query",
			"vsql" => $this->vsql
		);
		return $jt->encode($attrs);
	}
}