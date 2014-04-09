<?php
/**
 * @author awknaust
 */
require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';
require_once 'ViskoPipeline.php';
require_once 'ViskoQuery.php';

class ViskoPipelineSet implements JsonDeserializable, JsonCerializable{
	private $artifactURL;
	private $pipelines;
	private $query;


	public function __construct(){
		$this->pipelines = [];
	}
	
	public function fromJson($result){

		$this->artifactURL = $result->artifactURL;

		$this->query = new ViskoQuery();
		
		$this->query->fromJson($result->query);
		
		$this->pipelines = array();
		foreach ($result->pipelines as $jsonpipe){
			$pipe = new ViskoPipeline();
			$pipe->fromJson($jsonpipe);
			array_push($this->pipelines, $pipe);
		}
	}
	
	public function toJson(){
		
		$jpipes = array();
		foreach ($this->pipelines as $pipe){
			$jpipes[] = $pipe->toJson();
		}
		
		$jarr = array(
			'artifactURL' => $this->artifactURL,
			'query' => $this->query->toJson(),
			'pipelines' => $jpipes
		);
		
		return $jarr;
	}

	/**
	 * Adds a pipeline to this pipelineset.
	 * 
	 * @param ViskoPipeline $vpipeline
	 */
	public function addPipeline($vpipeline){
		$this->pipelines[] = $vpipeline; 	
	}
	
	/**
	 * Get this pipelineset's array of Pipeline objects.
	 *
	 * @return array of Pipeline objects:
	 */
	public function getPipelines(){
		return $this->pipelines;
	}
	
	/**
	 * Set the pipelineset's generating query.
	 * @param ViskoQuery $vquery
	 */
	public function setQuery($vquery){
		$this->artifactURL = $vquery->getArtifactURL();
		$this->query = $vquery;
	}

	/**
	 * Get the pipelineset's generating query
	 * @return ViskoQuery
	 */
	public function getQuery(){
		return $this->query;
	}

	/**
	 * Gets the URL of the input data from the pipelineset
	 */
	public function getArtifactURL(){
		return $this->artifactURL;
	}
	
	/**
	 * Groups pipelines by their toolkit
	 * 
	 * @return an associated array of Toolkitname -> pipelines
	 */
	public function groupPipelinesByToolkit(){
		$grouped = array();
		foreach($this->pipelines as $pipe){
			$tk = parse_url($pipe->getToolkitThatGeneratesView(), PHP_URL_FRAGMENT);
			if (! array_key_exists($tk, $grouped)){
				$grouped[$tk] = array();
			}
			array_push($grouped[$tk], $pipe);
		}
		return $grouped;
	}
}
