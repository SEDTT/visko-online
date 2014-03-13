<?php
/**
 * @author awknaust
 */

require_once 'JsonDeserializable.php';
		
class ViskoPipeline implements JsonDeserializable{
	private $viewURI;
	private $viewerURI;
	private $services;
	private $viewerSets;
	private $requiresInputURL;
	private $toolkitThatGeneratesView;
	private $outputFormat;

	/**
	 * Creates a Pipeline object from JSON
	 * @param string $json json_decoded object representing a pipeline
	 */
	public function fromJson($json){
		$this->viewURI = $json->viewURI;
		$this->viewerURI = $json->viewerURI;
		$this->requiresInputURL = $json->requiresInputURL;
		$this->toolkitThatGeneratesView = $json->getToolkitThatGeneratesView;
		$this->outputFormat = $json->getOutputFormat;

		$this->services = array();
		foreach($json->services as $service){
			array_push($this->services, $service);
		}

		$this->viewerSets = array();
		foreach($json->viewerSets as $viewerSet){
			array_push($this->viewerSets, $viewerSet);
		}

	}

	public function getViewURI(){
		return $this->viewURI;
	}

	public function getViewerURI(){
		return $this->viewerURI;
	}

	/**
	 * Get an array of Services that make up this pipeline. Each service is a URL
	 *
	 * @return array of strings:
	 */
	public function getServices(){
		return $this->services;
	}

	/**
	 * Get an array of viewersets for this pipeline
	 * @return array of strings:
	 */
	public function getViewerSets(){
		return $this->viewerSets;
	}

	/**
	 * Get the Toolkit that generates the view (VTK,Paraview,etc.)
	 */
	public function getToolkitThatGeneratesView(){
		return $this->toolkitThatGeneratesView;
	}

	public function getOutputFormat(){
		return $this->outputFormat;
	}
}