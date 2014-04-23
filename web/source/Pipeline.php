<?PHP
	require_once 'viskoapi/ViskoPipeline.php';
	require_once 'viskoapi/ViskoVisualizer.php';
	require_once 'history/PipelineError.php';
	require_once 'PipelineStatus.php';

	class Pipeline{
		protected $id;
		protected $queryID;
		protected $viskoPipeline;

		/**
		* Construct a Pipeline from parameters.
		*
		* @param queryID int the ID of the query that generated this Pipeline
		* @param viewURI String a View URI?
		* @param viewerURI String a viewer URI?
		* @param toolkit String the URI of the toolkit that generated the View
		* @param requiresInputURL boolean whether this pipeline requires input
		* @param outputFormat String URI the outputFormat of this pipeline
		* @param services array(String) an ordered set of URIs that are this pipeline's steps
		* @param viewerSets array(String) a set of viewer set URIs ?.
		* @param id int the database id of this object.
		*/
		public function __construct($queryID, $viewURI = null, $viewerURI = null, $toolkit = null, $requiresInputURL = null, $outputFormat = null, $services = array(), $viewerSets = array(), $id = null){
			$this->id = $id;
			$this->queryID = $queryID;
			
			$vp = new ViskoPipeline();
			$vp->init(
				$viewURI,
				$viewerURI,
				$toolkit,
				$requiresInputURL,
				$outputFormat,
				$services,
				$viewerSets
			);

			$this->viskoPipeline = $vp;
		}

		/**
		* @deprecated - use forwarding methods instead to avoid dealing with Visko directly.
		*/
		public function getViskoPipeline(){
			return $this->viskoPipeline;
		}
		
		/**
		 * Execute a pipeline and return a PipelineStatus.
		 * 
		 * @pre this.getID() > 0 -- already saved in database
		 * @pre this.getQueryID() == generatingQuery.getQueryID() -- query generated this pipeline.
		 * @pre this.services->notEmpty() --pipeline has actual services to execute.
		 * @pre informally ('this pipeline is not already executing on backend (unique id)')
		 * 
		 * @param Query $generatingQuery the query that generated this pipeline object.
		 * @return PipelineStatus the status of the result.
		 * @throws BackendConnectException (cannot connect to backend, programmer error)
		 * @throws ServiceTimeoutError if one of the pipeline services times out during execution.
		 * @throws InputDataURLError if input data is unreachable.
		 * @throws Exception if pipeline is already executing/other programmer error
		 */
		public function execute($generatingQuery){
			assert($generatingQuery->getID() == $this->getQueryID());
			assert($this->getID() > 0);
			assert($this->getServices() != null && count($this->getServices()) > 0);
			
			$vquery = $generatingQuery->getViskoQuery();
			$vv = new ViskoVisualizer();
			
			try{
				//execute via viskovisualizer
				list($vps, $errors) = $vv->executePipeline($this->getID(),
						 $vquery, $this->getViskoPipeline());
				
				if($errors !=null && count($errors) > 0){
					$this->inspectErrors($errors);
				}else {
					assert($vps != null);
					
					//create a pipelinestatus from the response
					$ps = new PipelineStatus(
							$this->getID(),
							$vps->getCompletedNormally(),
							$vps->getResultURL(),
							$vps->getServiceIndex()
					);
					
					return $ps;
				}
			}catch(BackendConnectException $bce){
				throw $bce;
			}
			
		}

		/**
		 * Translates viskoapis error types into history style exceptions.
		 *
		 * //TODO add support for other errors.
		 * //TODO refactor this so it doesnt have to know about viskobackend types
		 * @throws ServiceTimeoutError if query is invalid or unexecutable.
		 * @throws InputDataURLError if pipeline's input data url is unreachable.
		 * @throws Exception if Pipeline is already executing/other error
		 */
		private function inspectErrors($pipelineErrors){
			$etypes = [];
			foreach ($pipelineErrors as $pe){
				$etypes[$pe->type] = $pe;
			}
			
			if(array_key_exists('InputDataURLError', $etypes)){
				$err = $etypes['InputDataURLError'];
				throw new InputDataURLError($this->getUserID(), $this->getID(),
					$err->inputDataURL);	
			}

			else if(array_key_exists('PipelineExecutionTimeoutError', $etypes)){
				$err = $etypes['PipelineExecutionTimeoutError'];
				throw new ServiceTimeoutError($this->getUserID(), $this->getID(),
					$err->serviceIdx, $this->getServices()[$err->serviceIdx]);	
			}
			
			//this is likely due to programmer error
			else if(array_key_exists('PipelineExecutionError', $etypes)){
				$err = $etypes['PipelineExecutionError'];
				throw new Exception($err->message);
			}
		}
		
		public function setID($id){
			$this->id = $id;
		}

		public function getID(){
			return $this->id;
		}

		public function getQueryID(){
			return $this->queryID;
		}

//////////forwarded methods to ViskoPipeline///////////

		/**
		* @return String ?
		*/
		public function getViewURI(){
			return $this->getViskoPipeline()->getViewURI();
		}

		/**
		* @return String ?
		*/
		public function getViewerURI(){
			return $this->getViskoPipeline()->getViewerURI();
		}

		/**
		* @return array(String) URIs of services for this pipeline.
		*/
		public function getServices(){
			return $this->getViskoPipeline()->getServices();
		}

		/**
		* @return array(String) URIss of viewerSets for this pipeline.
		*/
		public function getViewerSets(){
			return $this->getViskoPipeline()->getViewerSets();
		}

		/**
		* @return String the URI of the toolkit that generates the view (i.e. .../vtk, ../para-view)
		*/
		public function getToolkitURI(){
			return $this->getViskoPipeline()->getToolkitThatGeneratesView();
		}

		public function getOutputFormat(){
			return $this->getViskoPipeline()->getOutputFormat();
		}

		public function getRequiresInputURL(){
			return $this->getViskoPipeline()->getRequiresInputURL();
		}
	}
	
?>
