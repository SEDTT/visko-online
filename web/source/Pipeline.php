<?PHP
	require_once 'viskoapi/ViskoPipeline.php';

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
