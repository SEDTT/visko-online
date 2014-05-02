<?php

require_once __DIR__ . '/../ConfigurationManager.php';
require_once 'JsonTransformer.php';
require_once 'ViskoPipeline.php';
require_once 'ViskoError.php';
require_once 'ViskoPipelineSet.php';

class BackendConnectException extends Exception{}

/**
	Class responsible for contacting the ViskoBackend and parsing
	the responses. Deals primarily with Visko** objects.

	@author awknaust
*/
class ViskoVisualizer{
	
	private $backendLocation;
	private static $queryURL = 'query';
	private static $executeURL = 'execute';
	private static $statusURL = 'status';

	function __construct(){
		$cfgMgr = new ConfigurationManager();
		$this->backendLocation = $cfgMgr->getBackendLocation();
	}
	
	/**
	 * Generates PipelineSet from a query.
	 * 
	 * @param ViskoQuery $vquery the query from which to generate pipelines
	 *
	 * @throws BackendConnectException if the visko backend could not be contacted
	 * 
	 * @return array(ViskoPipelineSet, array(ViskoError))
	 */
	public function generatePipelines($vquery){
		//assert($vquery->getQueryText() != null && trim($vquery->getQueryText()) != '');

		$jt = new JsonTransformer();
		$jsondQuery = $jt->encode($vquery->toJson());
		
		$data = ['query' => $jsondQuery];
		$url = $this->joinURL($this->backendLocation, self::$queryURL);

		$response = $this->sendByPost($url, $data);
		
		$decoded = $jt->decode($response);
		
		if($decoded->pipelines != null){
			$pipelines = new ViskoPipelineSet();
			$pipelines->fromJson($decoded->pipelines);
		}else{
			$pipelines = null;
		}
		
		$errors = $this->getErrors($decoded);
		
		return array($pipelines, $errors);
	}
	
	/**
	 * Execute a pipeline given its generating query and a unique identifier
	 * 
	 * @param int $id
	 * @param ViskoQuery $vquery
	 * @param ViskoPipeline $vpipeline

	 * @throws BackendConnectException if the visko backend could not be
	 * contacted
	 * 
	 *	@return array(ViskoPipelineStatus, array(ViskoError))
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
		
		$url = $this->joinURL($this->backendLocation, self::$executeURL);
		
		
		/* Parse response from backend */
		$response = $this->sendByPost($url, $data);
		$decoded = $jt->decode($response);
		
		if($decoded->status != null){
			$pipeStatus = new ViskoPipelineStatus();
			$status = $pipeStatus->fromJson($decoded->status);
		}else{
			$pipeStatus = null;
		}
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
		/*
		$viskoErrors = [];
		foreach ($visResponse->errors as $verr){
			$ve = new ViskoError();
			$ve->fromJson($verr);
			$viskoErrors[] = $ve;
		}
		return $viskoErrors;
		*/
	}

	/**
	* Gets a pipeline status, (forwards raw json)
	*/
	public function pollPipelineStatus($id){
		$data = ['id' => $id];
		
		$url = $this->joinURL($this->backendLocation, self::$statusURL);
		
		/* Parse response from backend */
		$response = $this->sendByPost($url, $data);
		
		return $response;

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
	 *
	 * @throws BackendConnectException If failed to reach the backend server 
	 * @return string text response
	 */
	protected function sendByPost($url, $data){
		
		$options = array(
				'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\n",
						'method'  => 'POST',
						'content' => http_build_query($data),
				),
		);
		
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		if($result == false){
			throw new BackendConnectException("Could not reach ViskoBackend
				server at URL : ". $url);
		}else{	
			return $result;
		}
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
				null, null, null,
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
