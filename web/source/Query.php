<?PHP
	require_once 'viskoapi/ViskoQuery.php';
	require_once 'viskoapi/ViskoVisualizer.php';
	require_once 'history/QueryError.php';
	require_once 'Pipeline.php';

	class Query{
		protected $id;
		protected $userID;
		protected $viskoQuery;
		protected $dateSubmitted;

		/** Initialize a Query from input text, 
		 * or input all of the necessary parameters 
		**/
		public function __construct($userID, $queryText, $formatURI, $typeURI, $targetFormatURI = null, 
			$targetTypeURI = null, $viewURI = null, $viewerSetURI = null, 
			$artifactURL = null, $parameterBindings = [], $dateSubmitted = null, 	
			$id = null){
		
			$this->viskoQuery = new ViskoQuery();
			$this->viskoQuery->init($queryText, $formatURI, $typeURI, $targetFormatURI,
				 $targetTypeURI, $viewURI, $viewerSetURI, 
				$artifactURL, $parameterBindings
			);
			
			$this->userID = $userID;
			//assumes submission when you create it
			if($dateSubmitted){
				$this->dateSubmitted = $dateSubmitted;
			}else{
				$this->dateSubmitted = new DateTime();
			}

			$this->id = $id;
		}

		/** Submit this query and generate pipelines 
		*
		* @pre $this->getUserID() != null && $this->getID() != null
		* @pre informally("ViskoBackend visualization servlet is running")
		* @post informally("return pipelines or throw errors that are NOT committed to the database ")
		* 
		* TODO check for malformedURI errors?
		* 
		* @return array(Pipeline) an array of pipelines stemming from this query.
		* @throws BackendConnectException (cannot connect to backend, programmer error)
		* @throws SyntaxError if query has bad syntax.
		* @throws NoPipelineResultsError if query is correct, but generated 0 pipelines
		*/
		public function submit(){
			/* Some assertions, maybe include syntax error checking */
			//assert($this->getQueryText() != null);
			//assert($this->getUserID() > 0 && $this->getID() > 0);

			$vv = new ViskoVisualizer();

			/* Get viskopipelineset + errors */
			try{
				list($vps, $errors) = $vv->generatePipelines(
					$this->getViskoQuery());
				
				if($errors != null && count($errors) > 0){
					$this->inspectErrors($errors);
				}

				if($vps == null || count($vps->getPipelines()) == 0){
					throw new NoPipelineResultsError($this->getUserID(), $this->getID());
				}else{
					//translate viskopipelines to pipeline objects
					$pipes = $this->extractPipelines($vps->getPipelines());

					//update this query with parsed information from the returned ViskoQuery
					//TODO consider not doing this or keeping the same querytext.
					$this->viskoQuery = $vps->getQuery();

					return $pipes;
				}

			}catch(BackendConnectException $bce){
				throw $bce;
			}
		}

		/**
		* Translate an array of ViskoPipelines into Pipeline objects
		* @return array(Pipeline) Pipelines made from viskopipelines.
		*/
		private function extractPipelines($viskoPipelines){
			$pipes = [];
			
			foreach ($viskoPipelines as $vp){
				$p = new Pipeline(
					$this->getID(),
					$vp->getViewURI(),
					$vp->getViewerURI(),
					$vp->getToolkitThatGeneratesView(),
					$vp->getRequiresInputURL(),
					$vp->getOutputFormat(),
					$vp->getServices(),
					$vp->getViewerSets()
				);

				$pipes[] = $p;
			}
			return $pipes;
		}

		/**
		* Translates viskoapis error types into history style exceptions.
		* //TODO refactor this so it doesnt have to know about viskobackend types
		* @throws SyntaxError if query is invalid or unexecutable.
		*/
		private function inspectErrors($queryErrors){
			$etypes = [];
			foreach ($queryErrors as $qe){
				$etypes[$qe->type] = $qe;
			}

			if(array_key_exists('InvalidQueryException', $etypes)){
				throw new SyntaxError($this->getUserID(), $this->getID());
			}else if(array_key_exists('UnexecutableQueryException', $etypes)){
				throw new SyntaxError($this->getUserID(), $this->getID());
			}
		}

		public function setID($id){
			$this->id = $id;
		}

		/**
		* @deprecated use the forwarded methods instead!
		*/
		public function getViskoQuery(){
			return $this->viskoQuery;
		}

		public function getID(){
			return $this->id;
		}
		
		/* Alias for now (where is this used?) */
		public function getQueryID(){
			return $this->getID();
		}

		public function getUserID(){
			return $this->userID;
		}

		public function getDateSubmitted(){
			return $this->dateSubmitted;
		}

////////////////Forward the following getters to ViskoQuery ////////////////

		/**
		* @return the query as text
		*/
		public function getQueryText(){
			return $this->getViskoQuery()->getQueryText();
		}
	
		/**
		* @return the URI of the target data format (XML, PDF, etc.)
		*/
		public function getTargetFormatURI(){
			return $this->getViskoQuery()->getTargetFormatURI();
		}

		public function getTypeURI(){
			return $this->getViskoQuery()->getTypeURI();
		}

		public function getFormatURI(){
			return $this->getViskoQuery()->getFormatURI();
		}
		/**
		* @return the URI describing the type of the output format (what is this?)
		*/
		public function getTargetTypeURI(){
			return $this->getViskoQuery()->getTargetTypeURI();
		}

		public function getViewURI(){
			return $this->getViskoQuery()->getViewURI();
		}

		/**
		* @return the uri of the viewer set that can visualize the 
			results (web-browser, etc.)
		*/
		public function getViewerSetURI(){
			return $this->getViskoQuery()->getViewerSetURI();
		}

		/**
		* @return the URL of the input data that you fed to this query.
		*/
		public function getArtifactURL(){
			return $this->getViskoQuery()->getArtifactURL();
		}

		/**
		* @return an array of (uri (name) => value)
		*/
		public function getParameterBindings(){
			return $this->getViskoQuery()->getParameterBindings();
		}

		/**
		* Set a parameter binding. 
		*
		* @param String $parameter the name of the parameter (URI) to add.
		* @param String $value the new value of the parameter Binding
		*/
		public function setParameterBinding($parameter, $value){
			$this->getViskoQuery()->setParameterBinding($parameter, $value);
		}
	}
?>
