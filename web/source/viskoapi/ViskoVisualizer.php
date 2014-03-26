<?php

require_once '../ConfigurationManager.php';
require_once 'JsonTransformer.php';
require_once 'ViskoPipeline.php';

/**
	Class responsible for contacting the ViskoBackend and parsing
	the responses. Deals primarily with Visko** objects.

	@author awknaust
*/
class ViskoVisualizer{
	
	private $backendLocation;
	
	function __construct(){
		$cfgMgr = new ConfigurationManager();
		$this->backendLocation = $cfgMgr->getBackendLocation();
	}
	
	/**
	 * Generates PipelineSet from a query.
	 * 
	 * @param ViskoQuery $vquery the query from which to generate pipelines
	 * 
	 * @return array(ViskoPipelineSet, array(ViskoError))
	 */
	public function generatePipelines($vquery){

		$jt = new JsonTransformer();
		$jsondQuery = $jt->encode($vquery->toJson());
		
		$data = ['query' => $jsondQuery];
		$url = $this->joinURL($this->backendLocation, 'query');

		$response = $this->sendByPost($url, $data);
		
		$decoded = $jt->decode($response);
		
		$pipelines = new ViskoPipelineSet();
		$pipelines->fromJson($decoded->pipelines); 
		
		$errors = $this->getErrors($decoded);
		
		return array($pipelines, $errors);
	}
	
	/**
	 * Execute a pipeline given its generating query and a unique identifier
	 * 
	 * @param int $id
	 * @param ViskoQuery $vquery
	 * @param ViskoPipeline $vpipeline
	 */
	public function executePipeline($id, $vquery, $vpipeline){
		$jt = new JsonTransformer();
		
		$idpipe = new IdentifiedPipeline($id, $vpipeline);
		
		/* Build a pipelineset to submit */
		$pipes = new ViskoPipelineSet();
		$pipes->setQuery($vquery);
		$pipes->addPipeline($idpipe);
		
		$jpipes = $jt->encode($pipes->toJson());
		$data = ['pipelineset' => $jpipes];
		
		$url = $this->joinURL($this->backendLocation, 'execute');
		
		
		/* Parse response from backend */
		$response = $this->sendByPost($url, $data);
		$decoded = $jt->decode($response);
		
		$pipeStatus = new ViskoPipelineStatus();
		$status = $pipeStatus->fromJson($decoded->status);
		$errors = $this->getErrors($decoded);
		
		return array($pipeStatus, $errors);
	}
	
	/**
	 * Get list of errors associated with this response.
	 * 
	 * @param object $visResponse a json decoded VisualizatonResponse
	 */
	private function getErrors($visResponse){
		return $visResponse->errors;
	}
	
	/**
	 * Joins a base URL with an extension. I.e. 'http://localhost/' and 'query.php'
	 * 	to get 'http://localhost/query.php'
	 * 
	 * @param string $base
	 * @param string $extra
	 * @return string joined URL
	 */
	private function joinURL($base, $extra){

		return rtrim($base, '/') . '/' . ltrim($extra, '/');
	}
	
	/**
	 * POSTs data to a URL and gets response.
	 * 
	 * @param string $url location of Page
	 * @param assocarray $data array of post keys->data parameters
	 * @return string text response
	 */
	private function sendByPost($url, $data){
		
		$options = array(
				'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\n",
						'method'  => 'POST',
						'content' => http_build_query($data),
				),
		);
		
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		return $result;
	}
	
}

/**
 * Bind an integer identifaction to a ViskoPipeline.
 * Should only be used by ViskoVisualizer.
 * @author awknaust
 *
 */
class IdentifiedPipeline extends ViskoPipeline implements JsonCerializable{
	private $id;
	
	public function __construct($id, $vpipeline){
		/* Some data lost on the way, no big deal for serialization */
		parent::init(
				$vpipeline->viewURI,
				$vpipeline->viewerURI,
				$vpipeline->services,
				$vpipeline->viewerSets
				);
		$this->id = $id;
	}
	
	public function toJson(){
		$arr = parent::toJson();
		$arr['id'] = $this->id;
		return $arr;
	}
	
	public function getID(){
		return $this->id;
	}
	
}
