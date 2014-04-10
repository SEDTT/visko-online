<?php
/**
 * @author awknaust
 */

require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';
		
class ViskoPipeline implements JsonDeserializable, JsonCerializable{
	
	/* Actual fields */
	protected $viewURI;
	protected $viewerURI;
	protected $services;
	protected $viewerSets;
	
	/* pseudo-fields from JSON */
	protected $requiresInputURL;
	protected $toolkitThatGeneratesView;
	protected $outputFormat;

	
	public function init($viewURI, $viewerURI, $toolkitThatGeneratesView,
		$requiresInputURL, $outputFormat, $services, $viewerSets){
		assert(count($services) > 0);
		assert(count($viewerSets) > 0);

		$this->viewURI = $viewURI;
		$this->viewerURI = $viewerURI;
		$this->services = $services;
		$this->viewerSets = $viewerSets;
		$this->toolkitThatGeneratesView = $toolkitThatGeneratesView;
		$this->requiresInputURL = $requiresInputURL;
		$this->outputFormat = $outputFormat;
	}
	
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
	
	public function toJson(){
		$jarr = array(
			'viewURI' => $this->viewURI,
			'viewerURI' => $this->viewerURI,
			'services' => $this->services,
			'viewerSets' => $this->viewerSets,
		);
		
		return $jarr;
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

	/**
	* Returns boolean to determine if Pipeline requires a inputURL or not.
	*/
	public function getRequiresInputURL(){
		return $this->requiresInputURL;
	}
}
