<?PHP
	require_once 'viskoapi/ViskoQuery.php';

	class Query{
		protected $id;
		protected $userID;
		protected $viskoQuery;
		protected $dateSubmitted; //TODO what type is this?

		/** Initialize a Query from input text, 
		 * or input all of the necessary parameters 
		**/
		public function __construct($userID, $queryText, $formatURI = null, $typeURI = null, $targetFormatURI = null, 
			$targetTypeURI = null, $viewURI = null, $viewerSetURI = null, 
			$artifactURL = null, $parameterBindings = null, $dateSubmitted = null, 	
			$id = null){
		
			$this->viskoQuery = new ViskoQuery();
			$this->viskoQuery->init($queryText, $formatURI, $typeURI, $targetFormatURI,
				 $targetTypeURI, $viewURI, $viewerSetURI, 
				$artifactURL, $parameterBindings
			);
			
			$this->userID = $userID;
			$this->dateSubmitted = $dateSubmitted;
			$this->id = $id;
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
			return $this->dateSubmitted();
		}

////////////////Forward the following getters to ViskoQuery ////////////////

		/**
		* @return the query as text
		*/
		public function getQueryText(){
			return $this->getViskoQuery()->getQueryText();
		}
		
				/**
		* @return the query as text
		*/
		public function getFormatURI(){
			return $this->getViskoQuery()->getFormatURI();
		}
		
				/**
		* @return the query as text
		*/
		public function getTypeURI(){
			return $this->getViskoQuery()->getTypeURI();
		}
	
		/**
		* @return the URI of the target data format (XML, PDF, etc.)
		*/
		public function getTargetFormatURI(){
			return $this->getViskoQuery()->getTargetFormatURI();
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
	}
?>
