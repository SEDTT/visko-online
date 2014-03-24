<?php
/**
 * @author awknaust
 */
require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';
require_once 'ViskoPipeline.php';

class ViskoPipelineSet implements JsonDeserializable, JsonCerializable{
	private $artifactURL;
	private $pipelines;


	public function fromJson($result){

		$this->artifactURL = $result->artifactURL;

		$this->pipelines = array();
		foreach ($result->pipelines as $jsonpipe){
			$pipe = new ViskoPipeline();
			$pipe->fromJson($jsonpipe);
			array_push($this->pipelines, $pipe);
		}
	}
	
	public function toJson(){
		return "";
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