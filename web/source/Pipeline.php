<?PHP
	require_once 'viskoapi/ViskoPipeline.php';

	class Pipeline{
		protected $id;
		protected $queryID;
		protected $viskoPipeline;

		public function __construct($queryID, $viskoPipeline, $id = null){
			$this->id = $id;
			$this->queryID = $queryID;
			$this->viskoPipeline = $viskoPipeline;
		}

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
	}
?>
