<?php
require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';

class ViskoQuery implements JsonCerializable, JsonDeserializable{
	private $vsql;
	private $targetFormatURI;
	private $targetTypeURI;
	private $viewURI;
	private $viewerSetURI;
	private $artifactURL;
	private $parameterBindings;
	
	public function __construct(){
		
	}

	public function init($vsql, $targetFormatURI, $targetTypeURI, $viewURI, $viewerSetURI, $artifactURL){
		$this->vsql = $vsql;
		$this->targetFormatURI = $targetFormatURI;
		$this->targetTypeURI = $targetTypeURI;
		$this->viewURI = $viewURI;
		$this->viewerSetURI = $viewerSetURI;
		$this->artifactURL = $artifactURL;
	}
	
	public function getQueryText(){
		return $this->vsql;
	}
	
	public function getArtifactURL(){
		return $this->artifactURL;
	}
	
	public function getTargetFormatURI(){
		return $this->targetFormatURI;
	}
	
	public function getTargetTypeURI(){
		return $this->targetTypeURI;
	}
	
	public function getViewURI(){
		return $this->viewURI;
	}
	
	public function getViewerSetURI(){
		return $this->viewerSetURI;
	}
	
	public function setQueryText($queryText){
		$this->vsql = $queryText;
	}
	
	public function getParameterBindings(){
		return $this->parameterBindings;
	}

	public function toJson(){
		$attrs = array(
			"type" => "Query",
			"vsql" => $this->vsql
		);
		return $attrs;
	}
	
	public function fromJson($json){
		$this->vsql = $json->vsql;
		$this->targetFormatURI = $json->targetFormatURI;
		$this->targetTypeURI = $json->targetTypeURI;
		$this->viewURI = $json->viewURI;
		$this->viewerSetURI = $json->viewerSetURI;
		$this->artifactURL = $json->artifactURL;
	
		//var_dump($json->parameterBindings);	
		//$this->parameterBindings = array($json->parameterBindings);
	}
}
