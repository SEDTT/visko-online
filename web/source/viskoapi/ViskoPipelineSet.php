<?php
require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';
require_once 'ViskoPipeline.php';
require_once 'ViskoQuery.php';

/**
 * A record for an object received by the Viskobackend, it is a set of pipelines + the generating query.
 * Necessary also in order to send a pipeline execution request. (Has no corresponding object in model)
 *
 * @author awknaust
 */
class ViskoPipelineSet implements JsonDeserializable, JsonCerializable {
	private $artifactURL;
	private $pipelines;
	private $query;
	public function __construct() {
		$this->pipelines = [ ];
	}
	public function fromJson($result) {
		$this->artifactURL = $result->artifactURL;
		
		$this->query = new ViskoQuery ();
		
		$this->query->fromJson ( $result->query );
		
		$this->pipelines = array ();
		foreach ( $result->pipelines as $jsonpipe ) {
			$pipe = new ViskoPipeline ();
			$pipe->fromJson ( $jsonpipe );
			array_push ( $this->pipelines, $pipe );
		}
	}
	public function toJson() {
		$jpipes = array ();
		foreach ( $this->pipelines as $pipe ) {
			$jpipes [] = $pipe->toJson ();
		}
		
		$jarr = array (
				'artifactURL' => $this->artifactURL,
				'query' => $this->query->toJson (),
				'pipelines' => $jpipes 
		);
		
		return $jarr;
	}
	
	/**
	 * Adds a pipeline to this pipelineset.
	 *
	 * @param ViskoPipeline $vpipeline        	
	 */
	public function addPipeline($vpipeline) {
		$this->pipelines [] = $vpipeline;
	}
	
	/**
	 * Get this pipelineset's array of Pipeline objects.
	 *
	 * @return array of Pipeline objects:
	 */
	public function getPipelines() {
		return $this->pipelines;
	}
	
	/**
	 * Set the pipelineset's generating query.
	 * 
	 * @param ViskoQuery $vquery        	
	 */
	public function setQuery($vquery) {
		$this->artifactURL = $vquery->getArtifactURL ();
		$this->query = $vquery;
	}
	
	/**
	 * Get the pipelineset's generating query
	 * 
	 * @return ViskoQuery
	 */
	public function getQuery() {
		return $this->query;
	}
	
	/**
	 * Gets the URL of the input data from the pipelineset
	 */
	public function getArtifactURL() {
		return $this->artifactURL;
	}
}
